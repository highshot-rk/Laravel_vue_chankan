<template>
	<div class="process-table-tbody">
		<div class="process-table-tbody__inner">
            <template v-if="calendars.length > 0">
                <input type="hidden" v-bind:value="refreshVal">
                <!-- <div class="process-table-tbody__content" v-for="(calendar, id) in calendars" :key="id" :id="'group-'+ calendar.date.replace('/', '').replace('/', '')"> -->
                <div class="process-table-tbody__content" v-for="(calendar, id) in calendars" :key="id" :id="'group-'+ calendar.date.replace('/', '').replace('/', '')">
                    <!-- AM -->
                    <!-- <div class="process-table-tr work-field amcolumns" v-for="(amcolumn, lineNumber) in calendar.amcolumns" :key="`first-${lineNumber}`"> -->
                        <div class="process-table-tr work-field amcolumns" v-for="(amcolumn, lineNumber) in calendar.amcolumns" :key="amcolumn.lineNumber">
                        <div class="process-table-th day"><span v-if="amcolumn.day">{{ calendar.date }}({{ calendar.week }})</span></div>
                        <div class="process-table-th time">
                            <div class="work-field__time flex__wrap f__center v__center">
                                <div class="work-field__time__inner">
                                    <p>AM</p>
                                    <div class="field-edit flex__wrap f__center non__column">
                                        <a v-if="amcolumn.add" class="field-add field-button" @click.prevent.stop="amAddColumn(id)">追加</a>
                                        <a v-if="amcolumn.remove" class="field-delete field-button" @click.prevent.stop="amRemoveColumn(id, lineNumber)">削除</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="process-table-td" v-for="(manager, target) in managers" :key="manager.target">
                            <div class="work-field__work flex__wrap f__center v__center">
                                <draggable
                                    class="work-field__work__inner"
                                    group="tableContent"
                                    :animation="200"
                                    :forceFallback="true"
                                    :ref="id + 'amcolumns' + lineNumber + target"
                                    @choose="chooseProcess(calendars[id], 'amcolumns', lineNumber, target)"
                                    @add="addProcess(id, 'amcolumns', lineNumber, target)"
                                    @remove="removeProcess(id, 'amcolumns', lineNumber, target)"
                                    @clone="dragStart(id + 'amcolumns' + lineNumber + target)"
                                    @end="dragEnd(id + 'amcolumns' + lineNumber + target)"
                                >
                                    <div class="field__work__content" v-if="amcolumn.works[target]" @click="showWorkDetail(id, lineNumber, target, 'amcolumns')">
                                        <div class="workContent border-color" :class="getColorClassName(id, lineNumber, target, 'amcolumns')">
                                            <ul class="workContent__inner">
                                                <li class="flex__wrap">
                                                    <span v-if="amcolumn.works[target].projectType === 0" class="work erecting">架設</span>
                                                    <span v-else-if="amcolumn.works[target].projectType === 2" class="work dismantling">解体</span>
                                                    <!-- <span class="time">10:00-16:00</span> -->
                                                    <span class="beforeContact"><a @click.prevent.stop="showAdvanceNotice(id, lineNumber, target, 'amcolumns')">前日連絡</a></span>
                                                </li>
                                                <li class="project_name">{{ amcolumn.works[target].projectName }}</li>
                                                <!-- <li>{{ amcolumn.works[target].chargeName }}</li> -->
                                                <!-- <li>{{ amcolumn.works[target].userName }}</li> -->
                                                <!-- <li>{{ amcolumn.works[target].userCompany }}</li> -->
                                                <!-- <li>{{ amcolumn.works[target].projectAddress }}</li> -->
                                                <li>{{ amcolumn.works[target].projectRemark }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="field__work__content" v-if="amcolumn.memos[target]" @click="openMemoModal(id, lineNumber, target, 'amcolumns')">
                                        <div class="memoContent">
                                            <div class="memoContent__inner">
                                                <p>{{ amcolumn.memos[target].content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </draggable>
                                <div v-if="!amcolumn.works[target] && !amcolumn.memos[target]" class="work-field__work__button">
                                    <div class="work-field__work__button__inner flex__wrap f__center v__center">
                                        <a class="work-add add-button" @click.prevent.stop="openWorkModal(id, lineNumber, target, 'amcolumns')">案件追加</a>
                                        <a class="memo-add add-button" @click.prevent.stop="openMemoModal(id, lineNumber, target, 'amcolumns')">メモ追加</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PM -->
                    <div class="process-table-tr work-field pmcolumns" v-for="(pmcolumn, lineNumber) in calendar.pmcolumns" :key="pmcolumn.lineNumber">
                        <div class="process-table-th day"></div>
                        <div class="process-table-th time">
                            <div class="work-field__time flex__wrap f__center v__center">
                                <div class="work-field__time__inner">
                                    <p>PM</p>
                                    <div class="field-edit flex__wrap f__center non__column">
                                        <a v-if="pmcolumn.add" class="field-add field-button" @click.prevent.stop="pmAddColumn(id)">追加</a>
                                        <a v-if="pmcolumn.remove" class="field-delete field-button" @click="pmRemoveColumn(id, lineNumber)">削除</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="process-table-td" v-for="(manager, target) in managers" :key="manager.target">
                            <div class="work-field__work flex__wrap f__center v__center">
                                <draggable
                                    class="work-field__work__inner"
                                    group="tableContent"
                                    :animation="200"
                                    :forceFallback="true"
                                    :ref="id + 'pmcolumns' + lineNumber + target"
                                    @choose="chooseProcess(calendars[id], 'pmcolumns', lineNumber, target)"
                                    @add="addProcess(id, 'pmcolumns', lineNumber, target)"
                                    @remove="removeProcess(id, 'pmcolumns', lineNumber, target)"
                                    @clone="dragStart(id + 'pmcolumns' + lineNumber + target)"
                                    @end="dragEnd(id + 'pmcolumns' + lineNumber + target)"
                                >
                                    <div class="field__work__content" v-if="pmcolumn.works[target]" @click="showWorkDetail(id, lineNumber, target, 'pmcolumns')">
                                        <div class="workContent border-color" :class="getColorClassName(id, lineNumber, target, 'pmcolumns')">
                                            <ul class="workContent__inner">
                                                <li class="flex__wrap">
                                                    <span v-if="pmcolumn.works[target].projectType === 0" class="work erecting">架設</span>
                                                    <span v-else-if="pmcolumn.works[target].projectType === 2" class="work dismantling">解体</span>
                                                    <!-- <span class="time">10:00-16:00</span> -->
                                                    <span class="beforeContact"><a href="" @click.prevent.stop="showAdvanceNotice(id, lineNumber, target, 'pmcolumns')">前日連絡</a></span>
                                                </li>
                                                <!-- <li><a @click.prevent.stop="showWorkDetail(id, lineNumber, target, 'pmcolumns')">{{ pmcolumn.works[target].projectName }}</a></li> -->
                                                <li class="project_name">{{ pmcolumn.works[target].projectName }}</li>
                                                <!-- <li>{{ pmcolumn.works[target].chargeName }}</li> -->
                                                <!-- <li>{{ pmcolumn.works[target].userName }}</li> -->
                                                <!-- <li>{{ pmcolumn.works[target].userCompany }}</li> -->
                                                <!-- <li>{{ pmcolumn.works[target].projectAddress }}</li> -->
                                                <li>{{ pmcolumn.works[target].projectRemark }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="field__work__content" v-if="pmcolumn.memos[target]" @click="openMemoModal(id, lineNumber, target, 'pmcolumns')">
                                        <div class="memoContent">
                                            <div class="memoContent__inner">
                                                <p>{{ pmcolumn.memos[target].content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </draggable>
                                <div v-if="!pmcolumn.works[target] && !pmcolumn.memos[target]" class="work-field__work__button">
                                    <div class="work-field__work__button__inner flex__wrap f__center v__center">
                                        <a class="work-add add-button" @click.prevent.stop="openWorkModal(id, lineNumber, target, 'pmcolumns')">案件追加</a>
                                        <a class="memo-add add-button" @click.prevent.stop="openMemoModal(id, lineNumber, target, 'pmcolumns')">メモ追加</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 案件調整 -->
                    <div class="process-table-tr work-field yetcolumns" v-for="(yetcolumn, lineNumber) in calendar.yetcolumns" :key="yetcolumn.lineNumber">
                        <div class="process-table-th day"></div>
                        <div class="process-table-th time">
                            <div class="work-field__time flex__wrap f__center v__center">
                                <div class="work-field__time__inner">
                                    <p>案件調整</p>
                                    <div class="field-edit flex__wrap f__center non__column">
                                        <a v-if="yetcolumn.add" class="field-add field-button" @click.prevent.stop="yetAddColumn(id)">追加</a>
                                        <a v-if="yetcolumn.remove" class="field-delete field-button" @click="yetRemoveColumn(id, lineNumber)">削除</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="process-table-td" v-for="(manager, target) in managers" :key="manager.target">
                            <div class="work-field__work flex__wrap f__center v__center">
                                <draggable
                                    class="work-field__work__inner"
                                    group="tableContent"
                                    :animation="200"
                                    :forceFallback="true"
                                    :ref="id + 'yetcolumns' + lineNumber + target"
                                    @choose="chooseProcess(calendars[id], 'yetcolumns', lineNumber, target)"
                                    @add="addProcess(id, 'yetcolumns', lineNumber, target)"
                                    @remove="removeProcess(id, 'yetcolumns', lineNumber, target)"
                                    @clone="dragStart(id + 'yetcolumns' + lineNumber + target)"
                                    @end="dragEnd(id + 'yetcolumns' + lineNumber + target)"
                                >
                                    <div class="field__work__content" v-if="yetcolumn.works[target]" @click.prevent.stop="showWorkDetail(id, lineNumber, target, 'yetcolumns')">
                                        <div class="workContent border-color" :class="getColorClassName(id, lineNumber, target, 'yetcolumns')">
                                            <ul class="workContent__inner">
                                                <li class="flex__wrap">
                                                    <span v-if="yetcolumn.works[target].projectType === 0" class="work erecting">架設</span>
                                                    <span v-else-if="yetcolumn.works[target].projectType === 2" class="work dismantling">解体</span>
                                                    <span class="beforeContact"><a href="" @click.prevent.stop="showAdvanceNotice(id, lineNumber, target, 'yetcolumns')">前日連絡</a></span>
                                                </li>
                                                <li class="project_name">{{ yetcolumn.works[target].projectName }}</li>
                                                <!-- <li>{{ yetcolumn.works[target].chargeName }}</li> -->
                                                <!-- <li>{{ yetcolumn.works[target].userName }}</li> -->
                                                <!-- <li>{{ yetcolumn.works[target].userCompany }}</li> -->
                                                <!-- <li>{{ yetcolumn.works[target].projectAddress }}</li> -->
                                                <li>{{ yetcolumn.works[target].projectRemark }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="field__work__content" v-if="yetcolumn.memos[target]" @click="openMemoModal(id, lineNumber, target, 'yetcolumns')">
                                        <div class="memoContent">
                                            <div class="memoContent__inner">
                                                <p>{{ yetcolumn.memos[target].content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </draggable>
                                <div v-if="!yetcolumn.works[target] && !yetcolumn.memos[target]" class="work-field__work__button">
                                    <div class="work-field__work__button__inner flex__wrap f__center v__center">
                                        <a class="work-add add-button" @click.prevent.stop="openWorkModal(id, lineNumber, target, 'yetcolumns')">案件追加</a>
                                        <a class="memo-add add-button" @click.prevent.stop="openMemoModal(id, lineNumber, target, 'yetcolumns')">メモ追加</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
		</div>
	</div>
</template>

<script>
	import draggable from 'vuedraggable'
	import dayjs from 'dayjs';
	import 'dayjs/locale/ja';
	dayjs.locale('ja');

	export default {
        props: {
            isCharge: {
                type: String
            },
        },
		components: {
			draggable
        },
        data: function () {
            return {
                isDrag: true,
            }
        },
		filters: {},
        watch: {},
        computed: {
            refreshVal: function() {
                return this.$store.getters.getRefreshVal;
            },
            calendars: function() {
                return this.$store.getters.getCalendars;
            },
            managers: function() {
                return this.$store.getters.getManagerLists;
            },
        },
		created: function() {
            console.log(this.$store.state)
        },
		mounted: function() {
            // 基準日が変更したタイミングで、カレンダwーの日付を全て変更
			this.$store.watch(
				(state) => state.basicDate,() => {
					this.calendars = this.$store.getters.getCalendars;
				}
            );
        },
        updated:function() {
        },
		methods: {
            // beforeMove: function(evt) {
            //     return evt.draggedContext.element.name !== 'Meeting';
            // },

            // 案件の色IDに対応する、着色用のCSSのclass名を返却する
            getColorClassName: function(id, lineNumber, target, timeStatus) {
                let resultColor = '';
                let targetArea = this.calendars[id][timeStatus][lineNumber].works[target];
                if(targetArea) {
                    switch (Number(this.calendars[id][timeStatus][lineNumber].works[target].projectColor)) {
                        case 1:
                            resultColor = 'one';
                            break;
                        case 2:
                            resultColor = 'two';
                            break;
                        case 3:
                            resultColor = 'three';
                            break;
                        case 4:
                            resultColor = 'four';
                            break;
                        case 5:
                            resultColor = 'five';
                            break;
                        case 6:
                            resultColor = 'six';
                            break;
                        case 7:
                            resultColor = 'seven';
                            break;
                        case 8:
                            resultColor = 'eight';
                            break;
                        case 9:
                            resultColor = 'nine';
                            break;
                        case 10:
                            resultColor = 'ten';
                            break;
                    }
                }
                return resultColor;
            },

            // 工程表：移動操作
			// 工程表のアイテムを移動
			chooseProcess: function(calendars, timeStatus, lineNumber, target) {
				// 選択した工程
                let targetWork = calendars[timeStatus][lineNumber].works[target];
				// 選択したメモ
                let targetMemo = calendars[timeStatus][lineNumber].memos[target];

                // 案件・メモがある場合の条件分岐
				if(targetWork) {
                    this.$store.dispatch('choosetWork', targetWork);
				} else if (targetMemo) {
					this.$store.dispatch('choosetMemo', targetMemo);
				} else {
					console.log("error");
                };
			},
			// 工程表の情報を、移動後の配列に保存する
			addProcess: function(id, timeStatus, lineNumber, target) {
				let beforeDate = this.$store.getters.getBeforeDate;
				if(beforeDate["projectName"]) {
					this.$store.dispatch('addWork', {id, timeStatus, lineNumber, target})
				} else if(beforeDate["content"]) {
					this.$store.dispatch('addMemo', {id, timeStatus, lineNumber, target})
				} else {
					console.log("error");
                }
			},
			// 工程表を移動させる
			removeProcess: function(id, timeStatus, lineNumber, target) {
				let beforeDate = this.$store.getters.getBeforeDate;
				if(beforeDate["projectName"]) {
					this.$store.dispatch('removeWork', {id, timeStatus, lineNumber, target})
				} else if(beforeDate["content"]) {
					this.$store.dispatch('removeMemo', {id, timeStatus, lineNumber, target})
				} else {
					console.log("error");
                }
				//this.$store.commit('spliceCalendar');
            },
            // 他の案件・メモを、全て固定させる
            dragStart: function() {
                // 工程表のメモ・工程を持っている場合、class noDragを付与する
                const dragLists = document.querySelectorAll('.field__work__content');
                dragLists.forEach(function(drag) {
                    // field__work__innerにnoDrag classを付与
                    drag.parentElement.classList.add('noDrag');
                });
            },
            // 現場・メモを離した時に、全ての工程・メモをドラッグ&ドロップ可能に戻す
            dragEnd: function() {
                // class noDragを削除する
                const dragLists = document.querySelectorAll('.field__work__content');
                dragLists.forEach(function(drag) {
                    // field__work__innerにnoDrag classを付与
                    drag.parentElement.classList.remove('noDrag');
                });
            },

            // 工程表：行の操作
			// AMの行を追加
			amAddColumn: function(lineNumber) {
                // storeに'amAddColumn'とlineNumberに
                this.$store.commit('amAddColumn', lineNumber);
				// this.calendars[lineNumber]["amcolumns"].push({day: false, add: true, remove: true, works:[], memos:[] });
				// this.calendars.splice();
			},
			// AMの行を削除
			amRemoveColumn: function(calendarId, lineId) {
                if (confirm('本当に削除しますか？')) {
                    this.$store.commit('amRemoveColumn', {calendarId, lineId});
                }
				//this.calendars[calendarId].amcolumns.splice(lineId, 1);
                // this.calendars.splice();
			},
			// PMの行を追加
			pmAddColumn: function(lineNumber) {
                this.$store.commit('pmAddColumn', lineNumber);
				// this.calendars[lineNumber]["pmcolumns"].push({add: true, remove: true, works:[], memos:[] });
				// this.calendars.splice();
			},
			// PMの行を削除
			pmRemoveColumn: function(calendarId, lineId) {
                if (confirm('本当に削除しますか？')) {
                    this.$store.commit('pmRemoveColumn', {calendarId, lineId});
                }
				// this.calendars[calendarId].pmcolumns.splice(lineId, 1);
                // this.calendars.splice();
            },
			// 未定の行を追加
			yetAddColumn: function(lineNumber) {
                this.$store.commit('yetAddColumn', lineNumber);
			},
			// 未定の行を削除
			yetRemoveColumn: function(calendarId, lineId) {
                if (confirm('本当に削除しますか？')) {
                    this.$store.commit('yetRemoveColumn', {calendarId, lineId});
                }
            },

            // 登録モーダル
			// メモのモーダルをオープンする
			openMemoModal: function(calendarId, lineId, memberId, columnStatus) {
				this.$store.dispatch('sendid', {calendarId, lineId, memberId, columnStatus});
				this.$store.commit('showMemo');
				this.$store.commit('toggleMemoModal');
			},
			// 工程のモーダルをオープンする
			openWorkModal: function(calendarId, lineId, memberId, columnStatus) {
				this.$store.dispatch('sendid', {calendarId, lineId, memberId, columnStatus});
				this.$store.commit('showWork', columnStatus);
				this.$store.commit('toggleWorkModal');
            },
            // 工程の変更モーダルをオープンする
            editProject: function(calendarId, lineId, memberId, columnStatus) {
                this.$store.dispatch('sendid', {calendarId, lineId, memberId, columnStatus});
				this.$store.commit('showWork');
                this.$store.commit('toggleWorkModal');
            },
            // その他ページへ遷移する
            // 案件詳細ページへ遷移する
            showWorkDetail: function(id, lineNumber, target, timeStatus) {
                if(this.isCharge == 1) {
                    // window.open('/charge/projects/detail/' + this.calendars[id][timeStatus][lineNumber].works[target].projectId, '_blank');
                    window.location.href = '/charge/projects/detail/' + this.calendars[id][timeStatus][lineNumber].works[target].projectId;
                }
                // window.open('/projects/detail/' + this.calendars[id][timeStatus][lineNumber].works[target].projectId, '_blank');
                window.location.href = '/projects/detail/' + this.calendars[id][timeStatus][lineNumber].works[target].projectId;
            },
            // 前日連絡ページへ遷移する
            showAdvanceNotice: function(id, lineNumber, target, timeStatus) {
                if(this.isCharge == 1) {
                    // window.open('/charge/projects/advance-notice/' + this.calendars[id][timeStatus][lineNumber].works[target].projectId, '_blank');
                    window.location.href = '/charge/projects/advance-notice/' + this.calendars[id][timeStatus][lineNumber].works[target].projectId;
                }
                // window.open('/projects/advance-notice/' + this.calendars[id][timeStatus][lineNumber].works[target].projectId, '_blank');
                window.location.href = '/projects/advance-notice/' + this.calendars[id][timeStatus][lineNumber].works[target].projectId;
            },
        },
	}
</script>
