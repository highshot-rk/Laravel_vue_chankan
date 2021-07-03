<template>
	<div class="modal">
        <!-- 案件登録モーダル -->
		<div class="work-modal modal-wrap content__wrap" :class="{'is-open': this.$store.getters.getWorkModalActive}" @click.self="closeWorkModal">
			<form @submit.prevent="registerWork">
				<div class="content__floar">
					<div class="content__input">
						<div class="headline attention must">案件名</div>
						<div class="input__box">
							<input class="bgType" type="text" v-model="project.name" name="" required>
						</div>
					</div>
					<div class="content__input">
						<div class="headline attention must">営業担当</div>
						<div class="input__wrap">
							<div class="input__box selectBox">
								<select class="bgType" name="" v-model="project.charge_id" required>
                                    <template v-for="(charge, index) in charges">
									<!-- <template v-for="item in charges"> -->
										<!-- <option :label="item.name" :value="item.id" :key="item.name">{{ item.name }}</option> -->
									<!-- <option v-for="(charge, index) in charges" :key="charge.id" :value="charge.id">{{charge.name}}</option> -->
                                        <option v-if="charge.edit_type == 0" ::label="charge.name" :key="charge.id" :value="charge.id">{{charge.name}}</option>
                                    </template>
                                    <option label="未定" :value="0">未定</option>
								</select>
							</div>
						</div>
					</div>
					<div class="content__input">
						<div class="headline attention any">作業員</div>
                        <div class="input__box selectBox">
                        <!-- <input class="bgType" type="text" name="" v-model="project.name" required> -->
                            <select class="bgType" name="" v-model="project.worker_id">
                                <template v-for="(charge, index) in charges">
                                    <option :label="charge.name" :key="charge.id" :value="charge.id">{{charge.name}}</option>
                                </template>
                            </select>
                        </div>
					</div>
					<!-- <template v-if="project.enable_sms === 1 && mode !== 'advance_notice'"> -->
					<template>
						<div class="content__input">
							<div class="headline attention any">作業連絡を担当者に送る</div>
							<div class="content__confirmation">
								<label class="checkbox__label">送信する
									<!-- <input type="checkbox" name="" v-model="project.is_send_to_charge"> -->
									<input type="checkbox" name="" v-model="project.is_send_to_charge">
									<!-- <input type="checkbox" name=""> -->
									<div class="checkbox__block"></div>
								</label>
							</div>
						</div>
					</template>
					<div class="content__input">
						<div class="headline attention must">
                            <span v-if="mode !== 'advance_notice'">施工予定日</span>
                            <span v-else>到着予定時間</span>
                        </div>
                        <div class="input__wrap delete__wrap flex__wrap f__start v__center" v-for="(item, index) in work_on_array" :key="index">
                            <div class="input__box year">
                                <select
                                    name=""
                                    class="bgType"
                                    v-model="item.year"
                                    :ref="'yearSelect' + index"
                                    required>
                                    <!-- <template v-for="selectYear in selectYears"> -->
                                    <option v-for="(selectYear, index) in selectYears" :key="index" :value="selectYear">{{ selectYear }}</option>
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
                                <!-- <span @click="doOpen(index)"><img src="/assets/img/icon_calender_black.png"></span> -->
                                <span @click="doOpen(index)"><img src="https://cattobi.com/assets/img/icon_calender_black.png"></span>
                            </div>
                            <!-- <div class="input__delete" @click="deleteWorkOn(index)">
                                <span><img src="https://cattobi.com/assets/img/icon_minus_white.png"></span>
                            </div> -->
                            <vuejs-datepicker
                                :language="ja"
                                format="yyyy-MM-dd"
                                @selected="selected(index)"
                                :ref="'picker' + index"
                                v-model="pickedDate[index]">
                            </vuejs-datepicker>
                            <p>{{ item.pickerval }}</p>
                        </div>
					</div>
					<div class="content__input">
						<div class="headline attention any">案件お客様電話番号</div>
						<div class="input__wrap">
							<div class="input__box">
								<!-- <input class="bgType" type="number" name="" v-model="project.tel"> -->
								<input class="bgType" type="number" name="" v-model="project.tel">
							</div>
						</div>
					</div>
					<div class="content__input">
						<div class="headline attention any">郵便番号（※半角数字のみ入力可）</div>
						<div class="input__wrap flex__wrap f__start v__center">
							<div class="input__box post__one">
								<!-- <input class="bgType" type="text" name="" placeholder="000" v-model="zip_first"> -->
								<input class="bgType" type="text" name="" placeholder="000" v-model="zip_first">
							</div>
							-
							<div class="input__box post__two">
								<!-- <input class="bgType" type="text" name="" placeholder="0000" v-model="zip_second"> -->
								<input class="bgType" type="text" name="" placeholder="0000" v-model="zip_second">
							</div>
						</div>
					</div>
					<div class="content__input">
						<div class="headline attention must">住所</div>
						<div class="input__wrap">
							<div class="input__box">
								<!-- <input class="bgType" type="text" name="" v-model="project.address"> -->
								<input class="bgType" type="text" name="" v-model="project.address" required>
							</div>
						</div>
					</div>
					<div class="content__input">
						<div class="headline attention must">道路規制</div>
						<div class="input__wrap flex__wrap v__center">
							<div class="input__box tabButton">
								<!-- <input class="bgType" type="radio" name="" value="0" v-model="project.road" required> -->
								<input class="bgType" type="radio" name="" value="0" required  v-model="project.road">
								<label>特になし</label>
							</div>
							<div class="input__box tabButton">
								<!-- <input class="bgType" type="radio" name="" value="1" v-model="project.road"> -->
								<input class="bgType" type="radio" name="" value="1" v-model="project.road">
								<label>ショート現地</label>
							</div>
						</div>
					</div>
					<div class="content__input">
						<div class="headline attention any">備考</div>
						<div class="input__box">
							<!-- <textarea class="bgType" name="" placeholder="南面が狭小の為、近隣に注意して作業してください。" v-model="project.remark"></textarea> -->
							<textarea class="bgType" name="" placeholder="南面が狭小の為、近隣に注意して作業してください。" v-model="project.remark"></textarea>
						</div>
					</div>
					<div class="content__input">
						<div class="headline attention any">色</div>
						<div class="input__box">
							<!-- <textarea class="bgType" name="" placeholder="南面が狭小の為、近隣に注意して作業してください。" v-model="project.remark"></textarea> -->
							<ul class="flex__wrap selectColor">
								<li class="colorBox one"><input type="radio" ref="color1" v-model="project.process_color_id" value="1" name="colorGroup" @click="radioDeselection(1)"><label></label></li>
								<li class="colorBox two"><input type="radio" ref="color2" v-model="project.process_color_id" value="2" name="colorGroup" @click="radioDeselection(2)"><label></label></li>
								<li class="colorBox three"><input type="radio" ref="color3" v-model="project.process_color_id" value="3" name="colorGroup" @click="radioDeselection(3)"><label></label></li>
								<li class="colorBox four"><input type="radio" ref="color4" v-model="project.process_color_id" value="4" name="colorGroup" @click="radioDeselection(4)"><label></label></li>
								<li class="colorBox five"><input type="radio" ref="color5" v-model="project.process_color_id" value="5" name="colorGroup" @click="radioDeselection(5)"><label></label></li>
								<li class="colorBox six"><input type="radio" ref="color6" v-model="project.process_color_id" value="6" name="colorGroup" @click="radioDeselection(6)"><label></label></li>
								<li class="colorBox seven"><input type="radio" ref="color7" v-model="project.process_color_id" value="7" name="colorGroup" @click="radioDeselection(7)"><label></label></li>
								<li class="colorBox eight"><input type="radio" ref="color8" v-model="project.process_color_id" value="8" name="colorGroup" @click="radioDeselection(8)"><label></label></li>
								<li class="colorBox nine"><input type="radio" ref="color9" v-model="project.process_color_id" value="9" name="colorGroup" @click="radioDeselection(9)"><label></label></li>
								<li class="colorBox ten"><input type="radio" ref="color10" v-model="project.process_color_id" value="10" name="colorGroup" @click="radioDeselection(10)"><label></label></li>
							</ul>
						</div>
					</div>

					<div class="content__input">
						<div class="headline attention must">登録済み情報から探す</div>
						<div class="input__wrap">
							<div class="input__box selectBox" :class='{nonInput : is_new_project_orderer}' :disabled="is_new_project_orderer" :required="!is_new_project_orderer">
								<select class="bgType" name="" v-model="project_orderer_id">
                                    <template v-for="option in project_orderers">
                                        <option :value="option.id">{{ option.company }}</option>
                                    </template>
								</select>
							</div>
						</div>
						<div class="content__add flex__wrap f__center">
							<button @click.prevent="is_new_project_orderer = !is_new_project_orderer">
								新規の元請け情報を登録
								<span class="f__center"><img src="https://cattobi.com/assets/img/icon_add_white_bold.png"></span>
							</button>
						</div>
						<div class="input__add" v-if="is_new_project_orderer">
							<div class="content__input">
								<div class="headline attention must">会社名</div>
								<div class="input__box">
									<input class="bgType" type="text" name="" v-model="project_orderer.company" :required="is_new_project_orderer">
								</div>
							</div>
							<div class="content__input" v-if="!is_tel">
								<div class="headline attention must">電話番号</div>
								<div class="advice">（電話番号を登録すると、作業報告通知が自動で行われます。）</div>
								<div class="input__box">
									<input class="bgType" type="text" name="" v-model="project_orderer.phone" :required="!is_new_project_orderer">
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
					<div class="content__submit f__center">
						<div class="submit__box">
							<button type="submit">架設登録</button>
						</div>
					</div>
				</div>
			</form>
		</div>

        <!-- メモモーダル -->
		<div class="memo-modal modal-wrap content__wrap" :class="{'is-open': this.$store.getters.getMemoModalActive}" @click.self="closeMemoModal">
			<form @submit.prevent="registerMemo">
				<div class="content__floar">
					<div class="content__input">
						<div class="headline">自由に入力してください。</div>
						<div class="input__box">
							<textarea name="" class="bgType" v-model="content"></textarea>
						</div>
					</div>
					<div class="content__submit flex__wrap">
						<div class="submit__box">
							<button @click.prevent="deleteMemo">削除する</button>
						</div>
						<div class="submit__box">
							<button type="submit">メモ登録</button>
						</div>
					</div>
				</div>
			</form>
		</div>

        <!-- 工程表PDF出力の日付入力モーダル -->
		<div class="memo-modal modal-wrap content__wrap" :class="{'is-open': this.$store.getters.getPdfModalActive}" @click.self="closePdfModal">
			<form @submit.prevent="pdfDownload">
				<div class="content__floar">
					<div class="content__input">
						<div class="headline attention must">開始日</div>
						<div class="input__box">
							<vuejs-datepicker
								:language="ja"
								format="yyyy-MM-dd"
								class="bgType"
                                @selected="workOnFromSelected"
                                v-model="pdf.work_on_from_original"
                                :required = true
							>
							</vuejs-datepicker>
							<input type="" name="" class="bgType" v-model="pdf.work_on_from">
						</div>
					</div>
					<div class="content__input">
						<div class="headline attention must">終了日</div>
						<div class="input__box">
							<vuejs-datepicker
								:language="ja"
								format="yyyy-MM-dd"
								class="bgType"
                                @selected="workOnToSelected"
                                v-model="pdf.work_on_to_original"
							>
							</vuejs-datepicker>
							<input type="" name="" class="bgType" v-model="pdf.work_on_to">
						</div>
					</div>
					<div class="content__input">
						<div class="headline attention any">案件がない日付も出力</div>
						<div class="content__confirmation">
							<label class="checkbox__label">出力する
								<input type="checkbox" name="" v-model="pdf.is_all_day">
								<div class="checkbox__block"></div>
							</label>
						</div>
					</div>
					<div class="content__submit f__center">
						<div class="submit__box">
							<button type="submit">印刷</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>
<script>
	import vuejsDatepicker from 'vuejs-datepicker'
	import {ja} from 'vuejs-datepicker/dist/locale';
    import axios from "../../utilities/axios";
    import errorHandling from '../../utilities/handling'

	export default {
        props: {
            loginId: {
                type: String
            },
            isCharge: {
                type: String
            },
        },
		components: {
			'vuejs-datepicker': vuejsDatepicker
		},
		data: function() {
            return {
                ja: ja,
                DatePickerFormat: 'yyyy-MM-dd',
                pickedDate: [],
                minuteArray: ['00', '30'],
                hourArray: ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'],
                pdf: {
                    work_on_from: '',
                    work_on_to: '',
                    is_all_day: false,
                },
                checkRadio: '',
            }
        },
        created: function() {},
        beforeDestroy: function() {},
		mounted: function() {},
		updated: function() {
            let infoId = this.$store.state.infoId;
            if (this.$store.state.isWorkModalActive === false || infoId === undefined || infoId.calendarId === undefined || infoId.calendarId === "" || this.$store.state.isWorkLoading) {
                return;
            }
            var project = undefined
            if (this.$store.state.calendars[infoId.calendarId][infoId.columnStatus]) {
                project = this.$store.state.calendars[infoId.calendarId][infoId.columnStatus][infoId.lineId].works[infoId.memberId];
            }
            if (project !== undefined) {
                // 案件が登録済みの場合
                axios.get('/api/projects/' + project.projectId, {})
                    .then(result => {
                        result = result.data;
                        this.project = {
                            name: result.name,
                            charge_id: result.charge.id,
                            worker_id: result.worker,
                            is_send_to_charge: false,
                            tel: result.tel,
                            zip: result.zip,
                            address: result.address,
                            road:result.road,
                            remark: result.remark,
                            process_color_id:(result.process_color_id == null || result.process_color_id == undefined) ? "" : result.process_color_id,
                        }
                        this.work_on_array[0].year = result.work_on_date.split('-')[0];
                        this.work_on_array[0].month = result.work_on_date.split('-')[1];
                        this.work_on_array[0].day = result.work_on_date.split('-')[2];
                        this.work_on_array[0].time_type = result.time_type;
                        this.zip_first = result.zip.substring(0, 3);
                        this.zip_second = result.zip.substring(3, 7);
                        this.checkRadio = (result.process_color_id == null || result.process_color_id == undefined) ? "" : result.process_color_id;
                    })
                    .catch(result => {
                        console.log('err', result);
                    });
                this.$store.commit('setIsWorkLoading',true);
            } else if(project == undefined) {
                // 案件が未登録の場合
                // 案件の道路規制の初期表示
                this.project.road = 0
                // 作業員の初期表示
                // if(this.isCharge == 1) {
                //     // 担当者のページの場合
                //     this.project.worker_id = this.loginId
                // } else if(this.isCharge !== 1) {
                //     // ユーザーのページの場合
                //     this.project.worker_id = this.$store.state.managerLists[0]['id']
                // }
            }
        },
		methods: {
            // ラジオボタンのcheckedを外す
            radioDeselection: function(e) {
                // console.log(this.$refs['color' + e].checked);
                if(this.checkRadio == this.$refs['color' + e]) {
                    this.$refs['color' + e].checked = false
                    this.checkRadio = ''
                    this.project.process_color_id = ''
                } else {
                    this.checkRadio = this.$refs['color' + e];
                }
            },
			// 施工予定日のカレンダー
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
            // DatePickerから日付を選択時、内部の該当する変数へセットする
            workOnFromSelected: function() {
                let obj = this
                // 反映のタイミングの関係上、100ミリ秒の時間経過後にセットを行う
                setTimeout(function() {
                    obj.pdf.work_on_from =
                        obj.pdf.work_on_from_original.getFullYear() + '-' +
                        obj.zeroPadding(obj.pdf.work_on_from_original.getMonth()+1, 2) + '-' +
                        obj.zeroPadding(obj.pdf.work_on_from_original.getDate(), 2)
                }, 100)
            },
            workOnToSelected: function() {
                let obj = this
                // 反映のタイミングの関係上、100ミリ秒の時間経過後にセットを行う
                setTimeout(function() {
                    obj.pdf.work_on_to =
                        obj.pdf.work_on_to_original.getFullYear() + '-' +
                        obj.zeroPadding(obj.pdf.work_on_to_original.getMonth()+1, 2) + '-' +
                        obj.zeroPadding(obj.pdf.work_on_to_original.getDate(), 2)
                }, 100)
            },
            zeroPadding: function(num,length) {
                return ('0000000000' + num).slice(-length)
            },
			closeWorkModal: function() {
				this.$store.commit('toggleWorkModal');
			},
			closeMemoModal: function() {
				this.$store.commit('toggleMemoModal');
			},
			closePdfModal: function() {
				this.$store.commit('togglePdfModal');
			},
			registerMemo:function() {
				// memosにsubmitする
				// モーダルを閉じる
				let infoId = this.$store.getters.infoId;
				let content = this.content;
				this.$store.dispatch('registerMemo', {infoId, content});
				this.$store.commit('toggleMemoModal');
				this.content = '';
				//this.$store.state.calendars.splice();
            },
			deleteMemo:function() {
				// memoを削除する
				// モーダルを閉じる
				let infoId = this.$store.getters.infoId;
				this.$store.dispatch('deleteMemo', {infoId});
				this.$store.commit('toggleMemoModal');
				this.content = '';
            },
            // 案件を登録する
			registerWork: function() {
				this.$store.dispatch('registerWork');
                this.$store.commit('toggleWorkModal');
				// this.$store.state.calendars.splice();
            },
            // PDFを新しいタブで開く
            pdfDownload: function() {
				const isAllDay = this.pdf.is_all_day ? 1 : 0
                const url = '/pdf?work_on_from=' + this.pdf.work_on_from + '&work_on_to=' + this.pdf.work_on_to+ '&is_all_day=' + isAllDay
                window.open(url, '_blank')
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
		},
		computed: {
			// 年の選択肢
			selectYears: function() {
				let year = (new Date()).getFullYear() -1
				let years = []
				for (let i = 0; i < 2; i++) {
					years.push(year)
					year++
				}
				return years
            },
            // 案件登録に使用する各値をstateから取得
            content: {
                get() {return this.$store.state.content},
                set(val) { this.$store.commit('setContent', val)}
            },
            zip_first: {
                get() {return this.$store.state.zip_first},
                set(val) { this.$store.commit('setZipFirst', val)}
            },
            zip_second: {
                get() {return this.$store.state.zip_second},
                set(val) { this.$store.commit('setZipSecond', val)}
            },
            project: {
                get() {return this.$store.state.project},
                set(val) { this.$store.commit('setProject', val)}
            },
            work_on_array: {
                get() {return this.$store.state.work_on_array},
                set(val) { this.$store.commit('setWorkOnArray', val)}
            },
            //
            name: {
                get() {return this.$store.state.name},
                set(val) { this.$store.commit('setName', val)}
            },
            charge_id: {
                get() {return this.$store.state.charge_id},
                set(val) { this.$store.commit('setChargeId', val)}
            },
            worker_id: {
                get() {return this.$store.state.worker_id},
                set(val) { this.$store.commit('setWorkerId', val)}
            },
            is_send_to_charge: {
                get() {return this.$store.state.is_send_to_charge},
                set(val) { this.$store.commit('setIsSendToCharge', val)}
            },
            tel: {
                get() {return this.$store.state.tel},
                set(val) { this.$store.commit('setTel', val)}
            },
            address: {
                get() {return this.$store.state.address},
                set(val) { this.$store.commit('setAddress', val)}
            },
            road: {
                get() {return this.$store.state.road},
                set(val) { this.$store.commit('setRoad', val)}
            },
            remark: {
                get() {return this.$store.state.remark},
                set(val) { this.$store.commit('setRemark', val)}
            },
            process_color_id: {
                get() {return this.$store.state.process_color_id},
                set(val) { this.$store.commit('setProcessColorId', val)}
            },
            project_orderers: {
                get() {return this.$store.state.project_orderers},
                set(val) { this.$store.commit('setProjectOrderers', val)}
            },
            project_orderer: {
                get() {return this.$store.state.project_orderer},
                set(val) { this.$store.commit('setProjectOrderer', val)}
            },
            // project_charge: {
            //     get() {return this.$store.state.project_orderer},
            //     set(val) { this.$store.commit('setProjectCharge', val)}
            // },
            company: {
                get() {return this.$store.state.company},
                set(val) { this.$store.commit('setCompany', val)}
            },
            phone: {
                get() {return this.$store.state.phone},
                set(val) { this.$store.commit('setPhone', val)}
            },
            project_orderer_id: {
                get() {return this.$store.state.project_orderer_id},
                set(val) { this.$store.commit('setProjectOrdererId', val)}
            },
            year: {
                get() {return this.$store.state.year},
                set(val) { this.$store.commit('setYear', val)}
            },
            month: {
                get() {return this.$store.state.month},
                set(val) { this.$store.commit('setMonth', val)}
            },
            day: {
                get() {return this.$store.state.day},
                set(val) { this.$store.commit('setDay', val)}
            },
            id: {
                get() {return this.$store.state.id},
                set(val) { this.$store.commit('setId', val)}
            },
            time_type: {
                get() {return this.$store.state.time_type},
                set(val) { this.$store.commit('setTimeType', val)}
            },
            scheduled_arrival_time_from: {
                get() {return this.$store.state.scheduled_arrival_time_from},
                set(val) { this.$store.commit('setScheduledArrivalTimeFrom', val)}
            },
            scheduled_arrival_time_to: {
                get() {return this.$store.state.scheduled_arrival_time_to},
                set(val) { this.$store.commit('setScheduledArrivalTimeTo', val)}
            },
            is_register_phone_later: {
                get() {return this.$store.state.is_register_phone_later},
                set(val) { this.$store.commit('setIsRegisterPhoneLater', val)}
            },
            is_new_project_orderer: {
                get() {return this.$store.state.is_new_project_orderer},
                set(val) { this.$store.commit('setIsNewProjectOrderer', val)}
            },
            is_tel: {
                get() {return this.$store.state.is_tel},
                set(val) { this.$store.commit('setIsTel', val)}
            },
            // name: function() { return this.$store.state.name },
            // charge_id: function() { return this.$store.state.charge_id },
            // worker: function() { return this.$store.state.worker },
            // is_send_to_charge: function() { return this.$store.state.is_send_to_charge },
            // tel: function() { return this.$store.state.tel },
            // zip: function() { return this.$store.state.zip },
            // address: function() { return this.$store.state.address },
            // road: function() { return this.$store.state.road },
            // remark: function() { return this.$store.state.remark },
            // process_color_id: function() { return this.$store.state.process_color_id },
            // project_orderers: function() { return this.$store.state.project_orderers },
            // project_orderer : function() { return this.$store.state.project_orderer  },
            // company: function() { return this.$store.state.company },
            // phone: function() { return this.$store.state.phone },
            // id: function() { return this.$store.state.id },
            // year: function() { return this.$store.state.year },
            // month: function() { return this.$store.state.month },
            // day: function() { return this.$store.state.day },
            // time_type: function() { return this.$store.state.time_type },
            // scheduled_arrival_time_from: function() { return this.$store.state.scheduled_arrival_time_from },
            // scheduled_arrival_time_to: function() { return this.$store.state.scheduled_arrival_time_to },
            // is_register_phone_later: function() { return this.$store.state.is_register_phone_later },
            // is_new_project_orderer: function() { return this.$store.state.is_new_project_orderer },
            // is_tel: function() { return this.$store.state.is_tel },
            charges: function() { return this.$store.state.managerLists },
            calendars: {
                get() { return this.$store.state.calendars },
                set(val) { this.$store.commit('setCalendars') }
            },
        },
	}
</script>
