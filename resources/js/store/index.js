import Vue from 'vue'
import Vuex from 'vuex'
// import VueRouter from "vue-router"
import dayjs from 'dayjs';
import 'dayjs/locale/ja';
import axios from './../utilities/axios'
import errorHandling from './../utilities/handling'
import { result } from 'lodash';

dayjs.locale('ja');

Vue.use(Vuex)
    // Vue.use(VueRouter)

export default new Vuex.Store({
    components: {},
    state: {
        refreshVal: 0,
        isWorkModalActive: false,
        isMemoModalActive: false,
        isPdfModalActive: false,
        basicDate: dayjs(),
        calendars: [],
        managerLists: [],

        // 工程
        works: [],
        infoId: { calendarId: '', lineId: '', columnStatus: '', memberId: '' },
        memoBefore: '',
        workBefore: '',
        beforeDate: [],
        /**** 案件登録モーダルにて使用する項目 <BEGIN> ****/
        content: "",
        remarkId: null,
        zip_first: "",
        zip_second: "",
        project: {
            name: "",
            charge_id: "",
            worker: "",
            is_send_to_charge: false,
            tel: "",
            zip: "",
            address: "",
            road: "",
            remark: "",
            project_type: "",
            process_color_id: ""
        },
        project_orderers: [],
        project_orderer: {
            company: '',
            phone: '',
        },
        project_orderer_id: '',
        work_on_array: [{
            id: '',
            year: '',
            month: '',
            day: '',
            project_type: '',
            time_type: 1,
            scheduled_arrival_time_from: null,
            scheduled_arrival_time_to: null,
        }],
        is_register_phone_later: false,
        is_new_project_orderer: false,
        is_tel: false,
        reset_flg: true,
        table_array: [],
        scroll_height: 0,
        isWorkLoading: false,
        /**** 案件登録モーダルにて使用する項目 END ****/
    },
    getters: {
        getRefreshVal: state => {
            return state.refreshVal;
        },
        getWorkModalActive: state => state.isWorkModalActive,
        getMemoModalActive: state => state.isMemoModalActive,
        getPdfModalActive: state  => state.isPdfModalActive,
        getBasicDate: state       => state.basicDate,
        getScrollHeight: state    => state.scroll_height,
        // カレンダーに格納する日付の配列一覧（1ヵ月前〜2ヵ月後）
        getCalendars: (state, getters) => {
            let basicDay = getters.getBasicDate;
            let beforeMonth = basicDay.subtract(1, 'months');
            let afterMonth = basicDay.add(2, 'months');
            let totalDays = afterMonth.diff(beforeMonth, 'day');
            for (var i = 0; i < totalDays; i++) {
                state.calendars[i] = {
                    id: i,
                    date: beforeMonth.add(i, 'day').format('YYYY/MM/DD'),
                    week: beforeMonth.add(i, 'day').format('ddd'),
                    // amの列
                    // amcolumns: [{ day: true, add: true, remove: false, works: [], memos: [] }],
                    amcolumns: [{ day: true, add: true, remove: false, works: [], memos: [] }],
                    // pmの列
                    pmcolumns: [{ add: true, remove: false, works: [], memos: [] }],
                    // 案件調整の列
                    yetcolumns: [{ add: true, remove: false, works: [], memos: [] }],
                }
            }
            return state.calendars;
        },
        getManagerLists: state  => state.managerLists,
        getWorks: state         => state.works,
        getWorkInfo: state      => state.workInfo,
        infoId: state           => state.infoId,
        memoBefore: state       => state.memoBefore,
        getBeforeDate: state    => state.beforeDate,
        content: state          => state.content,
        getResetFlg: state      => state.reset_flg,
    },
    mutations: {
        // 元請け情報のセット
        async fetchProjectOrderers(state) {
            // 元請け情報を取得
            axios.get('/api/project-orderers', {})
                .then(result => {
                    state.project_orderers = result.data
                    if (result.data.length > 0) {
                        state.project_orderer_id = state.project_orderers[0].id
                    }
                })
                .catch(result => {
                    alert('元請け情報の取得に失敗しました。')
                })
        },

        // 営業担当者のセット
        async fetchCharges(state) {
            // 担当者情報を取得
            await axios.get('/api/charges', {})
                .then(result => {
                    state.managerLists = result.data;
                })
                .catch(result => {
                    alert('担当者情報の取得に失敗しました。')
                });
        },
        // 案件情報・メモ情報のセット
        async fetchProjectsAndRemarks(state) {
            // 案件情報を取得
            let projects
            await axios.get('/api/projects', {})
                .then(result => {
                    projects = result.data;
                })
                .catch(result => {
                    alert('案件情報の取得に失敗しました。')
                });
            // メモ情報を取得
            let chargeRemarks
            await axios.get('/api/charge-remarks', {})
                .then(result => {
                    chargeRemarks = result.data
                })
                .catch(result => {
                    alert('メモ情報の取得に失敗しました。')
                });
            // calendarsへ案件情報・メモ情報をセット
            for (let i = 0; i < state.calendars.length; i++) {
                /**
                 * 案件・メモ情報
                 */
                // calendarの施工日に該当する案件情報があるかチェック
                let filterDate = state.calendars[i].date.replaceAll('/', '-');
                for (let timeType = 0; timeType < 3; timeType++) {
                    // timeType: 1-AM, 2-PM, 0-案件調整
                    let tempProjects = [];
                    let tempRemarks = [];

                    let projectCount = [];
                    let remarkCount = [];

                    // 比較用配列
                    const diffTarget = [];
                    // 管理者の人数分のループ処理
                    for (let j = 0; j < state.managerLists.length; j++) {
                        let filterChargeId = state.managerLists[j].id;
                        let filterTimeType = timeType;
                        // プロジェクト
                        tempProjects[j] = projects.filter(project => {
                            return (project.work_on_date === filterDate) &&
                                (project.charge.id === filterChargeId) &&
                                (project.time_type === filterTimeType);
                        });
                        // メモ
                        tempRemarks[j] = chargeRemarks.filter(chargeRemark => {
                            return (chargeRemark.work_on_date === filterDate) &&
                                (chargeRemark.charge.id === filterChargeId) &&
                                (chargeRemark.time_type === filterTimeType);
                        });

                        // プロジェクトの最大数を取得
                        let projectItem = tempProjects[j].length
                        projectCount.push(projectItem)
                        // メモの最大数を取得
                        let remarkItem = tempRemarks[j].length
                        remarkCount.push(remarkItem)

                        // ラインごとの最大数を取得する
                        let lineMaxItem = tempProjects[j].length + tempRemarks[j].length;
                        diffTarget.push(lineMaxItem)
                    }
                    // 日付ごとのAM・PM・案件調整の最大列数
                    let lineMaxNumber = 0;
                    lineMaxNumber = Math.max.apply(null, diffTarget);

                    // 必要な行数の分だけループ
                    for (let j = 0; j < lineMaxNumber; j++) {

                        // 行数を追加
                        let columns = [];
                        switch (timeType) {
                            case 0: // 案件調整
                                columns = state.calendars[i].yetcolumns;
                                break;
                            case 1: // AM
                                columns = state.calendars[i].amcolumns;
                                break;
                            case 2: // PM
                                columns = state.calendars[i].pmcolumns;
                                break;
                        }
                        if (columns.length > j) {
                            // 何もしない
                        } else {
                            // 新の要素を追加
                            columns.push({
                                day: false,
                                add: true,
                                remove: true,
                                works: [],
                                memos: []
                            });
                        }
                        // 営業担当者ごとにループ
                        for (let z = 0; z < state.managerLists.length; z++) {
                            // メモ・架設の配列を作成
                            // 架設の配列
                            let project = tempProjects[z].pop();
                            // メモの配列
                            let chargeRemark = tempRemarks[z].pop();
                            let chargeNumber = state.managerLists[z].id;

                            // メモ・架設の配列を結合


                            // 案件情報を登録
                            if(project) {
                            // メモの内容で、メモの有無判定
                                let tempProject = {
                                    projectId: project.id,
                                    projectAddress: project.address,
                                    projectCharge: chargeNumber,
                                    projectColor: project.process_color_id,
                                    projectYear: project.work_on_date.split('-')[0],
                                    projectMonth: project.work_on_date.split('-')[1],
                                    projectDay: project.work_on_date.split('-')[2],
                                    projectName: project.name,
                                    projectTimeType: project.time_type,
                                    projectType: project.project_type,
                                    projectZip: project.zip,
                                    projectTel: project.tel,
                                    projectRoad: project.road,
                                    userName: project.project_orderer.president,        // 営業担当名
                                    userCompany: project.project_orderer.company,       // 会社名
                                    projectWorker: project.worker,
                                    projectRemark: project.remark,
                                    projectOrdererId: project.project_orderer.id,
                                }
                                columns[j].works[z] = tempProject;
                            }
                            // メモ情報を登録
                            if(chargeRemark) {
                                let tempRemarks = {
                                    content: chargeRemark.remarks,
                                    remarkId: chargeRemark.id,
                                }
                                let targetArea = j + projectCount[z]
                                console.log('ターゲットエリア：' + targetArea)
                                console.log('ターゲットエリア：' + columns[targetArea])
                                console.log('1：' + columns[1])
                                columns[j].memos[z] = tempRemarks;
                            }
                        }
                    }
                }
            }
            console.log('load data has finished')
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        // カレンダー初期表示用の処理を行う
        createCalendars(state) {
            let basicDay = state.basicDate
            let beforeMonth = basicDay.subtract(1, 'months');
            let afterMonth = basicDay.add(2, 'months');
            let totalDays = afterMonth.diff(beforeMonth, 'day');
            for (var i = 0; i < totalDays; i++) {
                state.calendars[i] = {
                    id: i,
                    date: beforeMonth.add(i, 'day').format('YYYY/MM/DD'),
                    week: beforeMonth.add(i, 'day').format('ddd'),
                    amcolumns: [{ day: true, add: true, remove: false, works: [], memos: [] }],
                    pmcolumns: [{ add: true, remove: false, works: [], memos: [] }],
                    yetcolumns: [{ add: true, remove: false, works: [], memos: [] }],
                }
            }
        },
        // 選択したカレンダーの値をstateに設定する
        selectCalendarChange(state, date) {
            this.commit('fetchProjectsAndRemarks');
            state.basicDate = dayjs(date.date);
        },
        // AM行を追加する
        amAddColumn(state, lineNumber) {
            state.calendars[lineNumber]["amcolumns"].push({
                day: false,
                add: true,
                remove: true,
                works: [],
                memos: []
            });
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        // PM行を追加する
        pmAddColumn(state, lineNumber) {
            state.calendars[lineNumber]["pmcolumns"].push({
                day: false,
                add: true,
                remove: true,
                works: [],
                memos: []
            });
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        // 調整行を追加する
        yetAddColumn(state, lineNumber) {
            state.calendars[lineNumber]["yetcolumns"].push({
                day: false,
                add: true,
                remove: true,
                works: [],
                memos: []
            });
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        // AM行を削除する
        amRemoveColumn(state, { calendarId, lineId }) {
            // 行に含まれる案件を一括削除を行う為の処理を追加する（API呼び出し）
            let removeProjects = [];
            let works = state.calendars[calendarId].amcolumns[lineId].works;
            if (works != undefined) {
                for (let i = 0; i < works.length; i++) {
                    if (works[i]) {
                        removeProjects.push(works[i].projectId);
                    }
                }
            }
            axios.post('/api/projects/delete-multi', { ids: removeProjects })
                .then(result => {
                    console.log('remove projects has succeeded!', removeProjects.length);
                })
                .catch(result => {
                    console.log('error', result);
                });

            // 行に含まれるメモを一括削除を行う為の処理を追加する（API呼び出し）
            let removeRemarks = [];
            let memos = state.calendars[calendarId].amcolumns[lineId].memos;
            if (memos != undefined) {
                for (let i = 0; i < memos.length; i++) {
                    if (memos[i]) {
                        removeRemarks.push(memos[i].remarkId);
                    }
                }
            }
            axios.post('/api/charge-remarks/delete-multi', { ids: removeRemarks })
                .then(result => {
                    console.log('remove remarks has succeeded!', removeRemarks.length);
                })
                .catch(result => {
                    console.log('error', result);
                });

            state.calendars[calendarId].amcolumns.splice(lineId, 1);
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        // PM行を削除する
        pmRemoveColumn(state, { calendarId, lineId }) {
            // 行に含まれる案件を一括削除を行う為の処理を追加する（API呼び出し）
            let removeProjects = [];
            let works = state.calendars[calendarId].pmcolumns[lineId].works;
            if (works != undefined) {
                for (let i = 0; i < works.length; i++) {
                    if (works[i]) {
                        removeProjects.push(works[i].projectId);
                    }
                }
            }
            axios.post('/api/projects/delete-multi', { ids: removeProjects })
                .then(result => {
                    console.log('remove projects has succeeded!', removeProjects.length);
                })
                .catch(result => {
                    console.log('error', result);
                });

            // 行に含まれるメモを一括削除を行う為の処理を追加する（API呼び出し）
            let removeRemarks = [];
            let memos = state.calendars[calendarId].pmcolumns[lineId].memos;
            if (memos != undefined) {
                for (let i = 0; i < memos.length; i++) {
                    if (memos[i]) {
                        removeRemarks.push(memos[i].remarkId);
                    }
                }
            }
            axios.post('/api/charge-remarks/delete-multi', { ids: removeRemarks })
                .then(result => {
                    console.log('remove remarks has succeeded!', removeRemarks.length);
                })
                .catch(result => {
                    console.log('error', result);
                });

            state.calendars[calendarId].pmcolumns.splice(lineId, 1);
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        // 案件調整を削除する
        yetRemoveColumn(state, { calendarId, lineId }) {
            // 行に含まれる案件を一括削除を行う為の処理を追加する（API呼び出し）
            let removeProjects = [];
            let works = state.calendars[calendarId].yetcolumns[lineId].works;
            if (works != undefined) {
                for (let i = 0; i < works.length; i++) {
                    if (works[i]) {
                        removeProjects.push(works[i].projectId);
                    }
                }
            }
            axios.post('/api/projects/delete-multi', { ids: removeProjects })
                .then(result => {
                    console.log('remove projects has succeeded!', removeProjects.length);
                })
                .catch(result => {
                    console.log('error', result);
                });

            // 行に含まれるメモを一括削除を行う為の処理を追加する（API呼び出し）
            let removeRemarks = [];
            let memos = state.calendars[calendarId].yetcolumns[lineId].memos;
            if (memos != undefined) {
                for (let i = 0; i < memos.length; i++) {
                    if (memos[i]) {
                        removeRemarks.push(memos[i].remarkId);
                    }
                }
            }
            axios.post('/api/charge-remarks/delete-multi', { ids: removeRemarks })
                .then(result => {
                    console.log('remove remarks has succeeded!', removeRemarks.length);
                })
                .catch(result => {
                    console.log('error', result);
                });

            state.calendars[calendarId].yetcolumns.splice(lineId, 1);
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        setBasicDate(state, val) {
            state.basicDate = dayjs(val)
        },

        backCalendarChange(state) {
            state.basicDate = state.basicDate.subtract(1, 'month');
            // 指定した期間の案件取得・メモ取得APIを呼び出し、calendarへ反映する
            this.commit('fetchProjectsAndRemarks');
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        nextCalendarChange(state) {
            state.basicDate = state.basicDate.add(1, 'month');
            // 指定した期間の案件取得・メモ取得APIを呼び出し、calendarへ反映する
            this.commit('fetchProjectsAndRemarks');
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        toggleWorkModal(state) {
            if (!state.isMemoModalActive) {
                this.commit('setIsWorkLoading', false);
            }
            state.isWorkModalActive = !state.isWorkModalActive;
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        toggleMemoModal(state) {
            state.isMemoModalActive = !state.isMemoModalActive;
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        togglePdfModal(state) {
            state.isPdfModalActive = !state.isPdfModalActive;
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },

        // メモの登録
        registerMemo(state, { infoId, content }) {
            // 返却されたIDをcalendarsの値へ返す
            state.calendars[infoId.calendarId][infoId.columnStatus][infoId.lineId].memos[infoId.memberId] = {
                content: content
            };
            let timeType = 0;
            switch (infoId.columnStatus) {
                case 'amcolumns':
                    timeType = 1;
                    break;
                case 'pmcolumns':
                    timeType = 2;
                    break;
                case 'yetcolumns':
                    timeType = 0;
                    break;
            };
            let params = {
                charge_id: state.managerLists[infoId.memberId].id,
                time_type: timeType,
                work_on: state.calendars[infoId.calendarId].date.replaceAll('/', '-'),
                remarks: content,
            };
            // メモ情報のIDがセットされていない場合は登録API、セットされている場合は更新APIを呼び出す
            if (!state.remarkId) {
                // 登録API
                axios
                    .post('/api/charge-remarks', params)
                    // 成功した場合
                    .then(result => {
                        // 成功アラート
                        console.log('メモの登録完了');

                        // 返却されたIDをcalendarsの値へ返す
                        state.calendars[infoId.calendarId][infoId.columnStatus][infoId.lineId].memos[infoId.memberId].remarkId = result.id;
                    })
                    // 失敗した場合
                    .catch(result => {
                        // 失敗アラート
                        console.log('メモの登録に失敗しました', result);
                    });
            } else {
                // 更新API
                axios
                    .put('/api/charge-remarks/' + state.remarkId, params)
                    .then(result => {
                        console.log('メモの更新完了');
                    })
                    .catch(result => {
                        console.log('メモの更新に失敗しました', result);
                    });
            }
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        // メモの削除
        deleteMemo(state, { infoId }) {
            // メモ情報のIDがセットされている場合のみ削除する
            if (state.remarkId) {
                axios.delete(`/api/charge-remarks/${state.remarkId}`)
                    .then(result => {
                        console.log('delete memo has succeeded!');
                        // 成功したタイミングでDOMから削除する
                        state.calendars[infoId.calendarId][infoId.columnStatus][infoId.lineId].memos[infoId.memberId] = "";
                        Vue.set(state, 'refreshVal', state.refreshVal + 1);
                    })
                    .catch(result => {
                        console.log('error', result);
                    });
            }

        },
        // メモの移動
        sendid(state, { calendarId, lineId, memberId, columnStatus }) {
            state.infoId.calendarId = calendarId;
            state.infoId.lineId = lineId;
            state.infoId.columnStatus = columnStatus;
            state.infoId.memberId = memberId;
        },
        // 架設登録
        registerWork(state) {
            // 元請け情報を取得する
            // 登録した現場の元請け会社ID
            let primeContactorId = state.project_orderer_id;
            // 元請けの配列一覧
            let primeContactors = state.project_orderers;
            // 元請けの配列から、登録した現場の元請け会社IDと同じ要素を取得する
            let targetPrimeContactor = primeContactors.find((object) => {
                return (object.id === primeContactorId);
            });

            // リクエストパラメータをセット
            let projects = [];
            for (var i = 0; i < state.work_on_array.length; i++) {
                let projectName = state.project.name;
                let projectCharge = state.project.charge_id;
                let projectWorker = state.project.worker;
                let projectYear = state.work_on_array[i].year;
                let projectMonth = state.work_on_array[i].month;
                let projectDay = state.work_on_array[i].day;
                let projectTimeType = state.work_on_array[i].time_type;
                let projectType = 0;                                     // 架設として登録
                let projectTel = state.project.tel;
                let projectZip = state.zip_first + state.zip_second;
                let projectAddress = state.project.address;
                let projectRoad = state.project.road;
                let projectRemark = state.project.remark;
                let projectColor = state.project.process_color_id;       // 色
                let userName = targetPrimeContactor.president;           // 元請け代表者名
                let userCompany = targetPrimeContactor.company;          // 元請け会社名
                projects[i] = {
                    projectName, projectCharge, projectWorker, projectYear, projectMonth, projectDay, projectTimeType, projectType, projectTel, projectZip, projectAddress, projectRoad, projectRemark, projectColor, userName, userCompany
                };
            }

            /* const params = this.setParams(); */
            state.project.work_on_date = state.work_on_array.map(item => {
                return {
                    id: item.id,
                    work_on: item.year + '-' + item.month + '-' + item.day,
                    time_type: item.time_type,
                    scheduled_arrival_time_from: item.scheduled_arrival_time_from,
                    scheduled_arrival_time_to: item.scheduled_arrival_time_to,
                }
            });
            state.project.zip = state.zip_first + state.zip_second;
            const params = {
                project: state.project,
                project_orderer: state.project_orderer,
                project_orderer_id: state.project_orderer_id,
                is_register_phone_later: state.is_register_phone_later,
                is_new_project_orderer: state.is_new_project_orderer,
                deleted_project_ids: state.deleted_project_ids,
            };

            // 登録APIを呼び出し
            axios.post('/api/projects', params)
                .then(result => {
                    console.log('register work has succeeded!');
                    // 複数登録がある場合の想定
                    for (let i = 0; i < projects.length; i++) {
                        // 該当する日付
                        let targetDate = projects[i].projectYear + '/' + projects[i].projectMonth + '/' + projects[i].projectDay;
                        // AM or PMの設定
                        let targetColumn = '';
                        if (projects[i].projectTimeType == 1) {
                            targetColumn = 'amcolumns';
                        } else if (projects[i].projectTimeType == 2) {
                            targetColumn = 'pmcolumns';
                        } else {
                            targetColumn = 0;
                        }
                        // 該当する配列を指定
                        let targetProject = state.calendars.filter(e => e.date == targetDate);
                        // データを挿入　※挿入先の日付・時間タイプにて、既に案件orメモが登録されている場合に対応できるようにする
                        if ((targetProject[0][state.infoId.columnStatus][state.infoId.lineId].works[state.infoId.memberId]) ||
                            (targetProject[0][state.infoId.columnStatus][state.infoId.lineId].memos[state.infoId.memberId])) {
                            state.infoId.lineId++;
                            if (state.infoId.columnStatus === 'amcolumns') {
                                targetProject[0][state.infoId.columnStatus].push({ day: false, add: true, remove: true, works: [], memos: [] }, );
                            } else {
                                targetProject[0][state.infoId.columnStatus].push({ day: false, add: true, remove: true, works: [], memos: [] }, );
                            }
                        }
                        // 案件情報を登録する
                        targetProject[0][state.infoId.columnStatus][state.infoId.lineId].works[state.infoId.memberId] = projects[i];
                        // 案件にIDを指定
                        targetProject[0][state.infoId.columnStatus][state.infoId.lineId].works[state.infoId.memberId].projectId = result.id;
                        Vue.set(state, 'refreshVal', state.refreshVal + 1);
                    }
                    state.project = {
                        name: "",
                        charge_id: "",
                        worker: "",
                        project_type: "",
                        is_send_to_charge: false,
                        tel: "",
                        zip: "",
                        address: "",
                        road: "",
                        remark: "",
                        process_color_id: ""
                    };
                    state.work_on_array = [];
                    state.work_on_array.push({
                        id: '',
                        year: '',
                        month: '',
                        day: '',
                        time_type: 1,
                        project_type: '',
                        scheduled_arrival_time_from: null,
                        scheduled_arrival_time_to: null,
                    });
                })
                .catch(result => {
                    errorHandling.errorMessage(result);
                });
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        // 工程移動
        sendWorkId(state, { calendarId, lineId, memberId, columnStatus }) {
            state.workInfo.calendarId = calendarId;
            state.workInfo.lineId = lineId;
            state.workInfo.columnStatus = columnStatus;
            state.workInfo.memberId = memberId;
        },
        // モーダル表示する案件をセット
        showWork(state) {
            // 営業担当者、施工日、時間タイプをセットする
            state.project.charge_id = state.managerLists[state.infoId.memberId].id;
            let workOn = state.calendars[state.infoId.calendarId].date.split('/');
            let timeType = -1;
            switch (state.infoId.columnStatus) {
                case 'amcolumns':
                    timeType = 1;
                    break;
                case 'pmcolumns':
                    timeType = 2;
                    break;
                case 'yetcolumns':
                    timeType = 0;
                    break;
            }
            state.work_on_array = [];
            state.work_on_array.push({
                id: '',
                year: workOn[0],
                month: workOn[1],
                day: workOn[2],
                time_type: timeType,
                // project_type: projectType,
                scheduled_arrival_time_from: null,
                scheduled_arrival_time_to: null,
            });
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        // モーダル表示するメモをセット
        showMemo(state) {
            // memosの内容が存在する場合のみ、セットする
            if (state.calendars[state.infoId.calendarId][state.infoId.columnStatus][state.infoId.lineId].memos[state.infoId.memberId]) {
                state.content = state.calendars[state.infoId.calendarId][state.infoId.columnStatus][state.infoId.lineId].memos[state.infoId.memberId].content;
                state.remarkId = state.calendars[state.infoId.calendarId][state.infoId.columnStatus][state.infoId.lineId].memos[state.infoId.memberId].remarkId;
            } else {
                state.content = '';
                state.remarkId = null;
            }
            // state.workInfo.calendarId = calendarId;
            // state.workInfo.lineId = lineId;
            // state.workInfo.columnStatus = columnStatus;
            // state.workInfo.memberId = memberId;
        },

        // 工程表のドラッグ&ドロップのメソッド
        // 工程表を案件を移動する際、前の情報を保存する
        choosetWork(state, targetWork) {
            state.beforeDate = targetWork;
        },
        // 工程表をメモを移動する際、前の情報を保存する
        choosetMemo(state, targetMemo) {
            state.beforeDate = targetMemo;
        },
        // 工程表の案件情報を、移動後の配列に保存する
        addWork(state, { id, timeStatus, lineNumber, target }) {
            // 時間タイプの数値を設定
            let timeStatusValue;
            switch (timeStatus) {
                case 'amcolumns':
                    timeStatusValue = 1;
                    break;
                case 'pmcolumns':
                    timeStatusValue = 2;
                    break;
                case 'yetcolumns':
                    timeStatusValue = 0;
                    break;
                default:
                    timeStatusValue = -1;
            }

            // 移動後の配列に保存
            state.calendars[id][timeStatus][lineNumber].works[target] = state.beforeDate;
            // 営業担当者の番号をセット
            state.calendars[id][timeStatus][lineNumber].works[target].projectCharge = state.managerLists[target].id;
            // 時間タイプをセット
            state.calendars[id][timeStatus][lineNumber].works[target].projectTimeType = timeStatusValue;
            // 施工日_年をセット
            state.calendars[id][timeStatus][lineNumber].works[target].projectYear = state.calendars[id].date.split('/')[0];
            // 施工日_月をセット
            state.calendars[id][timeStatus][lineNumber].works[target].projectMonth = state.calendars[id].date.split('/')[1];
            // 施工日_日をセット
            state.calendars[id][timeStatus][lineNumber].works[target].projectDay = state.calendars[id].date.split('/')[2];
            // 案件更新APIを呼び出す（移動先の施工日、時間タイプ、営業担当者へ変更）
            let project = state.calendars[id][timeStatus][lineNumber].works[target];

            // 工程表で移動した際のパラーメーターを保存
            let projectParams = {
                // AM・PM・未定
                time_type: project.projectTimeType,
                // 作業日
                work_on: state.calendars[id].date.replaceAll('/', '-'),
                // 担当者
                charge_id: state.managerLists[target].id,
            };

            // 選択した案件のIDを取得
            let moveProjectId = state.calendars[id][timeStatus][lineNumber].works[target].projectId;

            axios
                .put('/api/projects/' + moveProjectId, projectParams)
                .then(result => {
                    console.log('案件移動後の登録成功')
                    state.calendars[id][timeStatus][lineNumber].works[target].projectId = moveProjectId
                })
                .catch(error => {
                    console.log('案件移動後の登録失敗')
                    if (error.response) {
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                        console.log(error.response.statusText);
                        console.log(error.response.config);
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        // 工程表のメモを、移動後の配列に保存する
        addMemo(state, { id, timeStatus, lineNumber, target }) {
            // 移動先に情報があるかどうか
            let beforeMemo = state.calendars[id][timeStatus][lineNumber].memos[target];
            let beforeWork = state.calendars[id][timeStatus][lineNumber].works[target];

            state.calendars[id][timeStatus][lineNumber].memos[target] = state.beforeDate;
            // メモ更新APIを呼び出す（移動先の施工日、時間タイプ、営業担当者へ変更）
            let timeType;
            switch (timeStatus) {
                case 'amcolumns':
                    timeType = 1;
                    break;
                case 'pmcolumns':
                    timeType = 2;
                    break;
                case 'yetcolumns':
                    timeType = 0;
                    break;
                default:
                    timeType = -1;
            }

            let params = {
                charge_id: state.managerLists[target].id,
                time_type: timeType,
                work_on: state.calendars[id].date.replaceAll('/', '-'),
                remarks: state.beforeDate.content,
            };

            // 移動中のメモIDを取得する
            let moveMemoId = state.calendars[id][timeStatus][lineNumber].memos[target].remarkId
            // ライブラリaxiosを用いたAPI接続で、DBに移動の情報を登録する
            axios
                .put('/api/charge-remarks/' + moveMemoId , params)
                .then(result => {
                    if(beforeMemo || beforeWork) {
                        beforeMemo = '';
                        beforeWork = '';
                    }
                    console.log('メモの移動完了');
                    state.calendars[id][timeStatus][lineNumber].memos[target].remarkId = moveMemoId;
                })
                .catch(error => {
                    console.log('メモ移動後の登録失敗')
                    if (error.response) {
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                        console.log(error.response.statusText);
                        console.log(error.response.config);
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        // 工程表の案件情報を、移動前の配列から削除する
        removeWork(state, { id, timeStatus, lineNumber, target }) {
            let projectId = state.calendars[id][timeStatus][lineNumber].works[target].projectId;
            state.calendars[id][timeStatus][lineNumber].works[target] = "";
            // 現場移動後、API通信で現場を削除する
            // axios.delete('/api/projects/' + projectId)
            //     .then(result => {
            //         console.log('delete work has succeeded!');
            //     })
            //     .catch(result => {
            //         console.log(result);
            //     });
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },
        // 工程表のメモを、移動前の配列から削除する
        removeMemo(state, { id, timeStatus, lineNumber, target }) {
            let remarkId = state.calendars[id][timeStatus][lineNumber].memos[target].remarkId;
            state.calendars[id][timeStatus][lineNumber].memos[target] = "";
            // メモ移動後、API通信でメモを削除する
            // axios.delete('/api/charge-remarks/' + remarkId)
            //     .then(result => {
            //         console.log('delete memo has succeeded!');
            //     })
            //     .catch(result => {
            //         console.log(result);
            //     });
            Vue.set(state, 'refreshVal', state.refreshVal + 1);
        },

        spliceCalendar(state) {
            //state.calendars.splice();
        },
        setProjectOrdererId(state, val) {
            state.project_orderer_id = val;
        },
        setZipFirst(state, val) {
            state.zip_first = val;
        },
        setZipSecond(state, val) {
            state.zip_second = val;
        },
        setProject(state, val) {
            state.project = val;
        },
        setWorkOnArray(state, val) {
            state.work_on_array = val;
        },
        setName(state, val) {
            state.name = val;
        },
        setChargeId(state, val) {
            state.charge_id = val;
        },
        setWorker(state, val) {
            state.worker = val;
        },
        setIsSendToCharge(state, val) {
            state.is_send_to_charge = val;
        },
        setTel(state, val) {
            state.tel = val;
        },
        setZip(state, val) {
            state.zip = val;
        },
        setAddress(state, val) {
            state.address = val;
        },
        setRoad(state, val) {
            state.road = val;
        },
        setRemark(state, val) {
            state.remark = val;
        },
        setProcessColorId(state, val) {
            state.process_color_id = val;
        },
        setProjectOrderers(state, val) {
            state.project_orderers = val;
        },
        setProjectOrderer(state, val) {
            state.project_orderer = val;
        },
        setCompany(state, val) {
            state.company = val;
        },
        setPhone(state, val) {
            state.phone = val;
        },
        setId(state, val) {
            state.id = val;
        },
        setYear(state, val) {
            state.year = val;
        },
        setMonth(state, val) {
            state.month = val;
        },
        setDay(state, val) {
            state.day = val;
        },
        setTimeType(state, val) {
            state.time_type = val;
        },
        setScheduledArrivalTimeFrom(state, val) {
            state.scheduled_arrival_time_from = val;
        },
        setScheduledArrivalTimeTo(state, val) {
            state.scheduled_arrival_time_to = val;
        },
        setIsRegisterPhoneLater(state, val) {
            state.is_register_phone_later = val;
        },
        setIsNewProjectOrderer(state, val) {
            state.is_new_project_orderer = val;
        },
        setIsTel(state, val) {
            state.is_tel = val;
        },
        setContent(state, val) {
            state.content = val;
        },
        setCalendars(state, val) {
            state.calendars = val;
        },
        setResetFlg(state, val) {
            state.reset_flg = val;
        },
        setScrollHeight(state, val) {
            state.scroll_height = val;
        },
        changeManagerList(state, val) {
            const value = state.managerLists[val.oldIndex];
            const id = value["id"];
            const afterSort = state.managerLists[val.newIndex]["sort"];

            var params = {
                sort: afterSort,
            };

            axios.post(`/api/charges/sort/${id}`, params)
                .then(result => {
                    console.log("sort順更新完了");

                    if (val.newIndex < val.oldIndex) {
                        // 移動元の方が大きければ、全件ソート番号をインクリメント
                        for (let i = val.newIndex; i <= val.oldIndex - 1; i++) {
                            state.managerLists[i]["sort"] += 1;
                        }
                    } else if (val.oldIndex < val.newIndex) {
                        // 移動先の方が大きければ、全件ソート番号をデクリメント
                        for (let i = val.oldIndex + 1; i <= val.newIndex; i++) {
                            state.managerLists[i]["sort"] -= 1;
                        }
                    }

                    // 移動元のソート番号を移動先ソート番号に更新する
                    state.managerLists[val.oldIndex]["sort"] = afterSort;

                    // 並び替え処理
                    const tail = state.managerLists.slice(val.oldIndex + 1);
                    const head = state.managerLists.splice(0, val.oldIndex);
                    let listArray = [...head, ...tail];
                    listArray.splice(val.newIndex, 0, value);
                    state.managerLists = [...listArray]

                    Vue.set(state, 'refreshVal', state.refreshVal + 1);
                })
                .catch(result => {
                    errorHandling.errorMessage(result)
                })
        },
        setIsWorkLoading(state, val) {
            state.isWorkLoading = val;
        }
    },

    actions: {
        // 工程表の現在地を送る
        sendid({ commit }, { calendarId, lineId, memberId, columnStatus }) {
            commit('sendid', { calendarId, lineId, memberId, columnStatus });
        },
        // メモ登録
        registerMemo(context, { infoId, content }) {
            context.commit('registerMemo', { infoId, content });
        },
        // メモの削除
        deleteMemo(context, { infoId }) {
            context.commit('deleteMemo', { infoId });
        },
        setResetFlg(state, val) {
            state.reset_flg = val;
        },
        changeManagerList(state, val) {
            const value = state.managerLists[val.oldIndex];
            const tail = state.managerLists.slice(val.oldIndex + 1);
            const head = state.managerLists.splice(0, val.oldIndex)
            let listArray = [...head, ...tail];
            listArray.splice(val.newIndex, 0, value);
            state.managerLists = [...listArray]
        },
        // 架設登録
        registerWork(context, projects) {
            context.commit('registerWork', projects);
        },

        // 工程表を移動する際、前の情報を保存する
        choosetWork(context, targetWork) {
            context.commit('choosetWork', targetWork);
        },
        choosetMemo(context, targetMemo) {
            context.commit('choosetMemo', targetMemo);
        },
        // 工程表の情報を、移動後の配列に保存する
        addWork(context, { id, timeStatus, lineNumber, target }) {
            context.commit('addWork', { id, timeStatus, lineNumber, target });
        },
        addMemo(context, { id, timeStatus, lineNumber, target }) {
            context.commit('addMemo', { id, timeStatus, lineNumber, target });
        },
        // 工程表の情報を、移動前の配列から削除する
        removeWork(context, { id, timeStatus, lineNumber, target }) {
            context.commit('removeWork', { id, timeStatus, lineNumber, target });
        },
        removeMemo(context, { id, timeStatus, lineNumber, target }) {
            context.commit('removeMemo', { id, timeStatus, lineNumber, target });
        },
    },
    modules: {},
})
