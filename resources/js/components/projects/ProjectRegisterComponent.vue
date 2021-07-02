<template>
    <div class="allWrapper">
        <modal ref="modal" @parentMethod="executeMethod">
            <template v-slot:message>{{ message }}</template>
            <template v-slot:ok>OK</template>
            <template v-slot:cancel>戻る</template>
        </modal>
        <div class="content__wrap">
            <div class="content__section">

                <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1" v-if="mode === 'undemolition-register'">未解体案件登録</h1>
                        <span class="en" v-if="mode === 'undemolition-register'">Undisassembled Register</span>

                        <h1 class="h1" v-if="mode === 'register'">新規架設登録</h1>
                        <span class="en" v-if="mode === 'register'">New Register</span>

                        <h1 class="h1" v-if="mode === 'edit'">現場編集</h1>
                        <span class="en" v-if="mode === 'edit'">Project Edit</span>

                        <h1 class="h1" v-if="mode === 'advance_notice'">前日連絡</h1>
                        <span class="en" v-if="mode === 'advance_notice'">Advance Notice</span>
                    </div>
                </div>

                <div class="content__floar">
                    <div class="content__floar__inner">
                        <div class="content__box">
                            <div class="content__box__inner">
                                <div class="content__input">
                                    <div class="headline attention must">案件名</div>
                                    <div class="input__box">
                                        <input class="bgType" type="text" name="" v-model="project.name" required>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline attention must">営業担当</div>
                                    <div class="input__wrap">
                                        <div class="input__box selectBox">
                                            <select class="bgType" name="" v-model="project.charge_id" required>
                                                <template v-for="item in charges">
                                                    <option :label="item.name" :value="item.id" :key="item.name">{{ item.name }}</option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <template v-if="project.enable_sms === 1 && mode !== 'advance_notice'">
                                    <div class="content__input">
                                        <div class="headline attention any">作業連絡を担当者に送る</div>
                                        <div class="content__confirmation">
                                            <label class="checkbox__label">
                                                送信する
                                                <input type="checkbox" name="" v-model="project.is_send_to_charge">
                                                <div class="checkbox__block"></div>
                                            </label>
                                        </div>
                                    </div>
                                </template>
                                <div class="content__input">
                                    <div class="headline attention must">施工予定日</div>

                                    <template v-for="(item, index) in work_on_array">
                                        <div class="input__wrap delete__wrap flex__wrap f__start v__center">
                                            <div class="input__box year">
                                                <!-- <select name="" class="bgType" v-model="item.year" :ref="'yearSelect' + index"> -->
                                                    <select
                                                        name=""
                                                        class="bgType"
                                                        v-model="item.year"
                                                        :ref="'yearSelect' + index"
                                                        required>
                                                    <template v-for="selectYear in selectYears">
                                                        <option :value="selectYear">{{ selectYear }}</option>
                                                    </template>
                                                </select>年
                                            </div>
                                            <div class="input__box month">
                                                <select name="" class="bgType" v-model="item.month" required>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                </select>月
                                            </div>
                                            <div class="input__box day">
                                                <select name="" class="bgType" v-model="item.day" required>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>日
                                            </div>
                                            <div class="input__box type">
                                                <select name="" class="bgType" v-model="item.time_type" required>
                                                    <option value="0">未定</option>
                                                    <option value="1">AM</option>
                                                    <option value="2">PM</option>
                                                </select>
                                            </div>
                                            <div class="input__box calender">
                                                <span @click="doOpen(index)"><img src="/assets/img/icon_calender_black.png"></span>
                                            </div>
                                            <div class="input__delete" @click="deleteWorkOn(index)">
                                                <span><img src="/assets/img/icon_minus_white.png"></span>
                                            </div>
                                            <vuejs-datepicker
                                                :language="ja"
                                                format="yyyy-MM-dd"
                                                @selected="selected(index)"
                                                :ref="'picker' + index"
                                                v-model="pickedDate[index]">
                                            </vuejs-datepicker>
                                            <p>{{ item.pickerval }}</p>
                                        </div>
                                        <div class="input__wrap flex__wrap f__center v__center non__column" v-if="mode === 'advance_notice'">
                                            <div class="input__box" style="margin-right: 1em;">
                                                <span>到着予定時間</span>
                                            </div>
                                            <div class="input__box twoInput">
                                                <select class="bgType" v-model="item.scheduled_arrival_time_from">
                                                    <template v-for="hour in hourArray">
                                                        <template v-for="minute in minuteArray">
                                                            <option :value="`${hour}:${minute}`" >{{ hour }}:{{ minute }}</option>
                                                        </template>
                                                    </template>
                                                    <!-- 30分ごとに、23:30まで -->
                                                </select>
                                            </div>
                                            〜
                                            <div class="input__box twoInput">
                                                <select class="bgType" v-model="item.scheduled_arrival_time_to">
                                                    <template v-for="hour in hourArray">
                                                        <template v-for="minute in minuteArray">
                                                            <option :value="`${hour}:${minute}`">{{ hour }}:{{ minute }}</option>
                                                        </template>
                                                    </template>
                                                    <!-- 30分ごとに、23:30まで -->
                                                </select>
                                            </div>

                                        </div>
                                    </template>
                                    <div class="content__add flex__wrap f__center">
                                        <button @click="addWorkOn">施工予定日を追加
                                            <span class="f__center"><img src="/assets/img/icon_add_white_bold.png"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline attention any">案件お客様電話番号</div>
                                    <div class="input__wrap">
                                        <div class="input__box">
                                            <input class="bgType" type="number" name="" v-model="project.tel">
                                        </div>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline attention any">郵便番号（※半角数字のみ入力可）</div>
                                    <div class="input__wrap flex__wrap f__start v__center">
                                        <div class="input__box post__one">
                                            <input class="bgType" type="text" name="" placeholder="000" v-model="zip_first">
                                        </div>
                                        -
                                        <div class="input__box post__two">
                                            <input class="bgType" type="text" name="" placeholder="0000" v-model="zip_second">
                                        </div>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline attention must">住所</div>
                                    <div class="input__wrap">
                                        <div class="input__box">
                                            <input class="bgType" type="text" name="" v-model="project.address">
                                        </div>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline attention must">道路規制</div>
                                    <div class="input__wrap flex__wrap v__center">
                                        <div class="input__box tabButton">
                                            <input class="bgType" type="radio" name="" value="0" v-model="project.road" required>
                                            <label>特になし</label>
                                        </div>
                                        <div class="input__box tabButton">
                                            <input class="bgType" type="radio" name="" value="1" v-model="project.road">
                                            <label>ショート現地</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline attention any">備考</div>
                                    <div class="input__box">
                                        <textarea class="bgType" name="" placeholder="南面が狭小の為、近隣に注意して作業してください。" v-model="project.remark"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content__section">
                <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1">元請け情報登録</h1>
                        <span class="en">Prime Contractor Register</span>
                    </div>
                </div>
                <div class="content__floar">
                    <div class="content__floar__inner">
                        <div class="content__box">
                            <div class="content__box__inner">
                                <div class="content__input">
                                    <div class="headline attention must">登録済み情報から探す</div>
                                    <div class="input__wrap">
                                        <div class="input__box selectBox" :class='{nonInput : is_new_project_orderer}' :disabled="is_new_project_orderer" :required="!is_new_project_orderer">
                                            <select class="bgType" name="" v-model="project_orderer_id">
                                                <template v-for="item in project_orderers">
                                                    <option :value="item.id">{{ item.company }}</option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="content__add flex__wrap f__center">
                                        <button @click="is_new_project_orderer = !is_new_project_orderer">
                                            新規の元請け情報を登録
                                            <span class="f__center"><img src="/assets/img/icon_add_white_bold.png"></span>
                                        </button>
                                    </div>
                                    <div class="input__add" v-if="is_new_project_orderer">
                                        <div class="content__input">
                                            <div class="headline attention must">会社名</div>
                                            <div class="input__box">
                                                <input class="bgType" type="" name="" v-model="project_orderer.company" :required="is_new_project_orderer">
                                            </div>
                                        </div>
                                        <div class="content__input" v-if="!is_tel">
                                            <div class="headline attention must">電話番号</div>
                                            <div class="advice">（電話番号を登録すると、作業報告通知が自動で行われます。）</div>
                                            <div class="input__box">
                                                <input class="bgType" type="" name="" v-model="project_orderer.phone" :required="!is_new_project_orderer">
                                            </div>
                                        </div>
                                        <div class="content__confirmation">
                                            <label class="checkbox__label">電話番号は後ほど登録する
                                                <input type="checkbox" name="" v-model="is_register_phone_later" @click="is_tel = !is_tel">
                                                <div class="checkbox__block"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content__submit f__center">
                <div class="submit__box">
                    <button type="button" name="" @click="registerProject" v-if="mode === 'register'">案件登録</button>
                    <button type="button" name="" @click="registerUndemolitionProject" v-if="mode === 'undemolition-register'">案件登録</button>
                    <button type="button" name="" @click="confirmUpdate" v-if="mode === 'edit'">案件編集</button>
                    <button type="button" name="" @click="confirmAdvanceNotice" v-if="mode === 'advance_notice'">前日連絡</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from './../../utilities/axios'
    import errorHandling from './../../utilities/handling'
    import Modal from '../common/Modal.vue'
    import vuejsDatepicker from 'vuejs-datepicker'
    import {ja} from 'vuejs-datepicker/dist/locale'

    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        components: {
            'modal' : Modal
        },
        props: {
            mode: {
                type: String
            },
            id: {
                type: Number
            },
            user_id: {
                type: Number
            },
            work_on_y: {
                type: String
            },
            work_on_m: {
                type: String
            },
            work_on_d: {
                type: String
            },
            isCharge: {
                type: String
            },
            isViewer: {
                type: String
            },
            urlPrefix: {
                type: String
            },
        },
        data() {
            // 必要に応じて変数を定義
            return {
                PROJECT_TYPE_ERECTION: 0,
                PROJECT_TYPE_UNDISASSEMBLED: 1,
                PROJECT_TYPE_DISASSEMBLED: 2,
                project: {
                    name: '',
                    charge_id: '',
                    work_on_date: [],
                    tel: '',
                    zip: '',
                    address: '',
                    road: 0,
                    remark: '',
                    is_send_to_charge: 0,
                },
                charges: [],
                project_orderers: [],
                project_orderer: {
                    company: '',
                    phone: '',
                },
                work_on_array: [
                    {
                        id: '',
                        year: '',
                        month: '',
                        day: '',
                        time_type: 1,
                        scheduled_arrival_time_from: null,
                        scheduled_arrival_time_to: null,
                    }
                ],
                project_orderer_id: '',
                deleted_project_ids: [],
                zip_first: '',
                zip_second: '',
                is_register_phone_later: false,
                is_new_project_orderer: false,
                is_tel: false,
                confirmMode: '',
                message: '',
                ja:ja,
                pickedDate: [],
                minuteArray: ['00', '30'],
                hourArray: ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23']
            }
        },
        components: {
            'vuejs-datepicker': vuejsDatepicker
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義

            // 編集画面or前日連絡画面or未解体案件登録画面である場合、案件詳細取得APIを呼び出す
            if ((this.mode === "edit") || (this.mode === "advance_notice") || (this.mode === "undemolition-register")) {
                // 案件情報を取得
                axios.get('/api/projects/'+this.id, {})
                    .then(result => {
                        this.project.name = result.data.name
                        this.project.charge_id = result.data.charge.id
                        this.project.tel     = result.data.tel
                        if (!result.data.zip) {
                            this.zip_first = ''
                        } else {
                            this.zip_first = result.data.zip.substring(0, 3)
                        }
                        if (!result.data.zip) {
                            this.zip_second = ''
                        } else {
                            this.zip_second = result.data.zip.substring(3, 7)
                        }
                        this.project.address = result.data.address
                        this.project.road    = result.data.road
                        this.project.remark  = result.data.remark
                        this.project_orderer_id      = result.data.project_orderer.id
                        this.project.is_send_to_user = result.data.is_send_to_user
                        this.project.is_send_to_charge = result.data.is_send_to_charge
                        this.project.enable_sms      = result.data.user.enable_sms
                        if ((this.mode === "edit") || (this.mode === "advance_notice")) {
                            this.work_on_array = []
                            result.data.label.projects.forEach(item => {
                                if (result.data.project_type === this.PROJECT_TYPE_ERECTION) {
                                    if (item.project_type === this.PROJECT_TYPE_ERECTION) {
                                        const dateDataSplit = item.work_on_date.split('-')
                                        const dateData = {
                                            id:                          item.id,
                                            year:                        dateDataSplit[0],
                                            month:                       dateDataSplit[1],
                                            day:                         dateDataSplit[2],
                                            time_type:                   item.time_type,
                                            scheduled_arrival_time_from: item.scheduled_arrival_time_from,
                                            scheduled_arrival_time_to:   item.scheduled_arrival_time_to,
                                        }
                                        this.work_on_array.push(dateData)
                                    }
                                } else if (result.data.project_type === this.PROJECT_TYPE_DISASSEMBLED) {
                                    if (item.project_type === this.PROJECT_TYPE_DISASSEMBLED) {
                                        const dateDataSplit = item.work_on_date.split('-')
                                        const dateData = {
                                            id:                          item.id,
                                            year:                        dateDataSplit[0],
                                            month:                       dateDataSplit[1],
                                            day:                         dateDataSplit[2],
                                            time_type:                   item.time_type,
                                            scheduled_arrival_time_from: item.scheduled_arrival_time_from,
                                            scheduled_arrival_time_to:   item.scheduled_arrival_time_to,
                                        }
                                        this.work_on_array.push(dateData)
                                    }
                                }
                            })
                        }
                    })
                    .catch(result => {
                        alert('案件情報の取得に失敗しました。')
                    })
            } else {
                // 会員情報を取得
                axios.get('/api/users/'+this.user_id, {})
                    .then(result => {
                        this.project.enable_sms = result.data.enable_sms
                    })
                    .catch(result => {
                        alert('ユーザ情報の取得に失敗しました。')
                    })
            }
            // 施工予定日を設定
            if (this.mode === "register") {
                if ((this.work_on_y != '') && (this.work_on_m != '') && (this.work_on_d != '')) {
                    this.work_on_array[0].year  = this.work_on_y
                    this.work_on_array[0].month = this.work_on_m
                    this.work_on_array[0].day   = this.work_on_d
                }
            }
            // 担当者情報を取得
            axios.get('/api/charges', {})
                .then(result => {
                    this.charges = result.data
                    if ((this.mode === "register") && (this.charges.length > 0)) {
                        this.project.charge_id = this.charges[0].id
                    }
                })
                .catch(result => {
                    alert('担当者情報の取得に失敗しました。')
                })
            // 元請け情報を取得
            axios.get('/api/project-orderers', {})
                .then(result => {
                    this.project_orderers = result.data
                    if ((this.mode === "register") && (this.project_orderers.length > 0)) {
                        this.project_orderer_id = this.project_orderers[0].id
                    }
                })
                .catch(result => {
                    alert('元請け情報の取得に失敗しました。')
                })
        },
        computed: {
            // 必要に応じてメソッドを定義

            // 年の選択肢を取得
            selectYears: function() {
                let year = (new Date()).getFullYear()
                let years = []
                for (let i = 0; i < 5; i++) {
                    years.push(year)
                    year++
                }
                return years
            }

        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義
            // 案件を登録する
            registerProject: function() {
                const params = this.setParams()
                axios.post('/api/projects', params)
                    .then(result => {
                        alert('案件を登録しました。')
                        // 登録後、現場_詳細の画面へ遷移
                        location.href = this.urlPrefix + '/projects/detail/' + result.id
                    })
                    .catch(result => {
                        errorHandling.errorMessage(result)
                    })
            },
            // 未解体案件を登録する
            registerUndemolitionProject: function() {
                const params = this.setParams()
                axios.post('/api/undemolition-projects/' + this.id, params)
                    .then(result => {
                        alert('未解体案件を更新しました。')
                        // 登録後、現場_詳細の画面へ遷移
                        location.href = this.urlPrefix + '/projects/detail/' + result.id
                    })
                    .catch(result => {
                        errorHandling.errorMessage(result)
                    })
            },
            // ボタン押下時、確認メッセージを表示する
            confirmUpdate: function() {
                this.confirmMode = 'update'
                this.message     = '案件を更新します。よろしいでしょうか。'
                this.$refs.modal.openModal()
            },
            // ボタン押下時、確認メッセージを表示する
            confirmAdvanceNotice: function() {
                this.confirmMode = 'advance_notice'
                if (!this.validateAdvanceNotice()) {
                    this.message = '施工予定日の時間帯およびは入力必須です。'
                    this.$refs.modal.openModal()
                } else {
                    this.message = '前日連絡を行います。よろしいでしょうか。'
                    this.$refs.modal.openModal()
                }
            },
            // 案件を更新する
            updateProject: function() {
                const params = this.setParams()
                axios.post('/api/projects/erection/' + this.id, params)
                    .then(result => {
                        alert('案件を更新しました。')
                        this.deleted_project_ids = []
                        // 案件更新後、一覧へ遷移
                        history.back(-1)
                    })
                    .catch(result => {
                        errorHandling.errorMessage(result)
                    })
            },
            // 前日連絡をする
            advanceNotice: function() {
                const params = this.setParams()
                axios.post('/api/projects/advance-notice/' + this.id, params)
                    .then(result => {
                        // API呼出し後、案件_前日連絡_完了画面へ遷移
                        location.href = this.urlPrefix + '/projects/advance-notice/' + this.id + '/sent'
                    })
                    .catch(result => {
                        errorHandling.errorMessage(result)
                    })
            },
            // APIへ渡すパラメータを返却する
            setParams: function() {
                this.project.work_on_date = this.work_on_array.map(item => {
                        return {
                            id:        item.id,
                            work_on:   item.year + '-' + item.month + '-' + item.day,
                            time_type: item.time_type,
                            scheduled_arrival_time_from: item.scheduled_arrival_time_from,
                            scheduled_arrival_time_to:   item.scheduled_arrival_time_to,
                        }
                    })
                this.project.zip = this.zip_first + this.zip_second
                const params = {
                    project:                 this.project,
                    project_orderer:         this.project_orderer,
                    project_orderer_id:      this.project_orderer_id,
                    is_register_phone_later: this.is_register_phone_later,
                    is_new_project_orderer:  this.is_new_project_orderer,
                    deleted_project_ids:     this.deleted_project_ids,
                }
                return params
            },
            // 施工予定日の欄を追加する
            addWorkOn: function() {
                this.work_on_array.push({
                        id: '',
                        year: '',
                        month: '',
                        day: '',
                        time_type: 1,
                    })
            },
            // 施工予定日の欄を削除する※(日付欄が1つのみの場合、削除しない)
            deleteWorkOn: function(index) {
                if (this.work_on_array.length > 1) {
                    if (this.work_on_array[index].id) {
                        this.deleted_project_ids.push(this.work_on_array[index].id)
                    }
                    this.work_on_array.splice(index, 1)
                }
            },
            // モーダルウインドウにてOKボタンが押下された後、対応する処理を行う
            executeMethod: function() {
                if (this.confirmMode === 'update') {
                    this.updateProject()
                } else if (this.confirmMode === 'advance_notice'){
                    if (this.validateAdvanceNotice()) {
                        this.advanceNotice()
                    }
                }
            },
            doOpen: function(index){
                if(!this.$refs['picker' + index][0].isOpen) {
                    this.$refs['picker' + index][0].showCalendar();
                } else if(this.$refs['picker' + index][0].isOpen) {
                    this.$refs['picker' + index][0].close(true);
                }
            },
            // DatePickerから日付を選択時、内部の該当する変数へセットする
            selected: function(index) {
                let obj = this
                // 反映のタイミングの関係上、100ミリ秒の時間経過後にセットを行う
                setTimeout(function() {
                    obj.work_on_array[index].year  = obj.pickedDate[index].getFullYear()
                    obj.work_on_array[index].month = obj.zeroPadding(obj.pickedDate[index].getMonth()+1, 2)
                    obj.work_on_array[index].day   = obj.zeroPadding(obj.pickedDate[index].getDate(), 2)
                }, 100)
            },
            zeroPadding: function(num,length) {
                return ('0000000000' + num).slice(-length)
            },
            validateAdvanceNotice: function() {
                let result = true
                this.work_on_array.forEach(item => {
                    if (!item.time_type || item.time_type == 0 || !item.scheduled_arrival_time_from || !item.scheduled_arrival_time_to) {
                        result = false
                    }
                })
                return result
            }
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
