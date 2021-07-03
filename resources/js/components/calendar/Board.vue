<template>
	<div class="proccess">
		<Modal :login-id="loginId" :is-charge="isCharge" />
		<header id="proccess-header">
			<div class="proccess-header-inner flex__wrap">
				<div class="proccess__back">
					<!-- <a onclick="javascript:window.history.back(-1);return false;">前の画面へ戻る</a> -->
					<a v-if="isCharge == 1" href="/charge/calendar">カレンダー画面へ戻る</a>
					<a v-else href="/calendar">カレンダー画面へ戻る</a>
				</div>

				<div class="proccess__calendar proccess__button">
					<ul class="flex__wrap">
						<li class="o-calendarBack"><a @click="backMonth">前月へ</a></li>
						<li class="calendarButton"><a><Datepicker :language="ja" @selected="selectCalendar"></Datepicker>カレンダーから日付を選択</a></li>
						<li class="o-calendarNext"><a @click="nextMonth">翌月へ</a></li>
					</ul>
				</div>
				<div class="proccess__print proccess__button">
					<ul class="flex__wrap">
                        <li style="margin-right: 5px;">
                            <a v-if="isCharge != 1" href="/charges/add">担当者追加</a>
                        </li>
                        <!-- <li><a @click.prevent="openPdfModal">印刷する</a></li> -->
                    </ul>
				</div>
			</div>
		</header>
		<main class="proccess__main">
			<div class="proccess__wrap">
				<div class="proccess__wrap__inner">
					<div class="process-table">
                        <!-- <div class="sub-block"></div>
                        <div class="sub-timeblock">AM / PM</div> -->
						<TableHead />
                        <TableBody v-if="reset_flg" :is-charge="isCharge" />
					</div>
				</div>
			</div>
		</main>
        <loading :active.sync="tableHeaderEnable"
            :can-cancel="false"
            color="#6495ed"
            :width="36"
            :height="36"
            :is-full-page="true">
        </loading>
	</div>
</template>
<script>
    import Vue from 'vue'
    import Vuex from 'vuex'
    import Modal from './ProcessModal'
    import TableHead from './TableHead'
    import TableBody from './TableBody'
    import Datepicker from 'vuejs-datepicker';
    import {ja} from 'vuejs-datepicker/dist/locale'
    import dayjs from 'dayjs';
    import 'dayjs/locale/ja';
    dayjs.locale('ja');
    Vue.use(Vuex)


	export default {
		components: {
			TableHead,
			TableBody,
			Modal,
			Datepicker
		},
        props: {
            loginId: {
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
		data: function() {
			return {
                ja: ja,
                reset_flg:true,
			}
		},
		created: function() {
            let day=dayjs();
            if(location.hash !== ""){
                day=dayjs(location.hash.replace('#group-','').slice(0,4)+"-"+location.hash.replace('#group-','').slice(4,6)+"-"+location.hash.replace('#group-','').slice(6,8));
            }
            this.$store.commit('setBasicDate',day)
        },
		mounted: function() {
            // 初期のカレンダー表示
            this.$store.commit('createCalendars')
            // 担当者情報を取得
            this.$store.commit('fetchCharges')
            // 元請け情報を取得
            this.$store.commit('fetchProjectOrderers')
            // 案件＆メモ情報を取得
            this.$store.commit('fetchProjectsAndRemarks');
            // 該当日付へスクロールする為、ページ内リンクを使用して遷移
            // （一度該当日付に遷移した後は、リダイレクトしないようにする）
            this.displayCalendar();
            this.$store.watch(
                (state) => state.reset_flg,() => {
                    if(this.$store.getters.getResetFlg == false){
                        this.reset_flg = this.$store.getters.getResetFlg;
                        this.$store.commit('createCalendars');
                        this.$store.commit('fetchProjectOrderers');
                        this.$store.commit('fetchProjectsAndRemarks');
                        this.reset_flg=true
                        this.$store.commit('setResetFlg',true);
                        setTimeout(()=>{
                            const divElement = document.getElementsByClassName("process-table")[0];
                            divElement.scrollTop=this.$store.getters.getScrollHeight
                        }, 500);
                    }
                }
            );
            if(window.location.hash!==""){
                window.location.href=window.location.pathname+'#group-'+this.$store.getters.getBasicDate.format('YYYYMMDD');
            }
        },
		methods: {
			// PDFモーダル表示
			openPdfModal: function() {
				this.$store.commit('togglePdfModal');
			},
			// カレンダー選択時
			selectCalendar: function(date) {
                // storeにカレンダーの値をcommitする
				this.$store.commit('selectCalendarChange', {
					date
                });
                // 初期のカレンダー表示
                this.displayCalendar();
			},
			backMonth: function() {
				this.$store.commit('backCalendarChange');
                this.displayCalendar();
			},
			nextMonth: function() {
                this.$store.commit('nextCalendarChange');
                this.displayCalendar();
            },
            // カレンダーの該当日付行へスクロール位置を変更する（アンカーリンクを踏む）
            displayCalendar: function() {
                let linkDate = this.$store.state.basicDate.format('YYYYMMDD');
                let pattern = linkDate
                if (!((window.location.href.lastIndexOf(linkDate) + pattern.length === window.location.href.length) && (linkDate.length <= window.location.href.length))) {
                    this.reset_flg=false
                    this.$nextTick(()=>{
                        this.reset_flg=true
                    })
                    // window.location.hash =  "#group-" + linkDate;
                    setTimeout(()=>{
                        window.location.hash = "#group-" + linkDate;
                    },0);
                }
            },
			scrollTop: function(){
				console.log(this.calendars[31].amcolumns[0].works)
			},
		},
		computed: {
            calendars: {
                get() { return this.$store.state.calendars },
                set(val) { this.$store.commit('setCalendars') }
            },
            tableHeaderEnable: function() {
                return !this.$store.getters.getTableHeaderEnable
            }
		}
	}
</script>
<style>
.is-full-page {
    height: 100%;
    position: fixed;
    top: 0;
    width: 100%;
    left: 0;
    margin: auto;
    background: rgba(0,0,0,0.3);
    z-index: 100000;
}
.vld-icon {
    position: absolute;
    top: 50%;
    left: 50%;
}
</style>

