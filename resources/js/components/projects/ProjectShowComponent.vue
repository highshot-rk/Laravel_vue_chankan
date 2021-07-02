<template>
  <div class="allWrapper">
    <modal ref="modal" @parentMethod="deleteProject">
        <template v-slot:message>{{ message }}</template>
        <template v-slot:ok>OK</template>
        <template v-slot:cancel>戻る</template>
    </modal>

    <div class="content__wrap detail__construction">
      <div class="content__section">

        <div class="content__header">
          <div class="content__title">
            <h1 class="h1">{{ project.name }}</h1>
            <span class="en">Project Detail</span>
          </div>
          <div class="content__edit">
            <ul class="flex__wrap f__start">
              <li v-if="project.project_type_name == '架設'">
                <a :href="url_survey">現場調査</a>
              </li>
              <template v-if="isViewer !== '1'">
                <li>
                    <a :href="url_advance_notice">前日連絡</a>
                </li>
                <li>
                    <a :href="url_edit">編集</a>
                </li>
                <li>
                    <a @click.prevent="confirm">削除</a>
                </li>
              </template>
            </ul>
            <template v-if="isViewer !== '1'">
                <ul class="flex__wrap f__start secondUl">
                    <template v-if="project.is_started === 0">
                        <li><a class="wide" @click.prevent="start">作業開始</a></li>
                        <li class="notClick" disabled><a class="wide">作業終了</a></li>
                    </template>
                    <template v-if="project.is_started === 1">
                        <li class="notClick" disabled><a class="wide">作業開始</a></li>
                        <li><a class="wide" :href="url_fin">作業終了</a></li>
                    </template>
                </ul>
            </template>
          </div>
        </div>

        <div class="content__error alert" v-if="!project.project_orderer.phone">
          <p>元請け業者の電話番号が登録されていません。<br>
          電話番号が登録されていない場合、自動メッセージ機能は実行されません。</p>
        </div>
        <div class="content__floar content__detail">
          <div class="content__floar__inner content__detail__inner">
            <template v-if="isViewer !== '1'">
              <div class="content__detail__content">
              <div class="content__input f__center">
                    <div class="submit__box detailLine line">
                    <!-- <a @click.prevent="sendToLine('with_orderer')">
                        この案件情報を
                        <br class="sp" />作業スタッフにLINEで送る
                    </a> -->
                    <a :href="new_line_url_open" target="_blank" rel="noopener noreferrer">
                        この案件情報を
                        <br class="sp" />作業スタッフにLINEで送る
                    </a>
                    <input type="hidden" id="url-with-orderer" :value="url_line_with_orderer">
                    </div>
                    <div class="linkBox">
                    <a @click.prevent="sendToLine('without_orderer')" class="textLink">元請け情報を含めずに送る場合はコチラ</a>
                    <input type="hidden" id="url-without-orderer" :value="url_line_without_orderer">
                    </div>
              </div>
              <div class="content__input f__center">
                    <div class="submit__box line detailLine black">
                    <a @click.prevent="copyUrlWithOrderer">URLをコピーする</a>
                    </div>
                    <div class="linkBox">
                    <a @click.prevent="copyUrlWithoutOrderer" class="textLink">元請け情報を含めずにコピーする場合はコチラ</a>
                    </div>
              </div>
              </div>
            </template>
            <div class="content__detail__content">
              <table class="detailTime">
                <tbody>
                  <tr>
                    <th>現場調査最終日時</th>
                    <td>
                      <span class="time">{{ project.surveyed_at }}</span>
                    </td>
                  </tr>
                  <tr>
                    <th>LINE最終日時</th>
                    <td>
                      <span class="time">{{ project.last_messaged_at }}</span>
                    </td>
                  </tr>
                  <tr>
                    <th>前日連絡最終日時</th>
                    <td>
                      <span class="time">{{ project.notified_at }}</span>
                    </td>
                  </tr>
                  <tr>
                    <th>作業開始日時</th>
                    <td>
                      <span class="time">{{ project.started_at }}</span>
                    </td>
                  </tr>
                  <tr>
                    <th>作業終了日時</th>
                    <td>
                      <span class="time">{{ project.finished_at }}</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="content__floar">
          <div class="content__floar__inner">
            <div class="content__box">
              <div class="content__box__inner">
                <div class="content__input">
                  <div class="headline">担当者名</div>
                  <div class="input__text">
                    <span>{{ project.charge.name }}</span>
                  </div>
                </div>
                <div class="content__input">
                  <div class="headline">タイプ</div>
                  <div class="input__text">
                    <span>{{ project.project_type_name }}</span>
                  </div>
                </div>
                <div class="content__input">
                  <div class="headline">施工予定日</div>
                  <div class="input__text">
                    <span>{{ project.work_on_string }} / {{ project.time_type_name }}</span>
                  </div>
                </div>
                <div class="content__input">
                  <div class="headline">到着予定時間</div>
                  <div class="input__text">
                    <span>{{ project.scheduled_arrival_time_from }}<span v-if="project.scheduled_arrival_time_from"> ～ </span>{{ project.scheduled_arrival_time_to }}</span>
                  </div>
                </div>
                <div class="content__input">
                  <div class="headline">案件お客様電話番号</div>
                  <div class="input__text">
                    <span>{{ project.tel }}</span>
                  </div>
                </div>
                <div class="content__input">
                  <div class="headline">郵便番号</div>
                  <div class="input__text">
                    <span>{{ project.zip }}</span>
                  </div>
                </div>
                <div class="content__input">
                  <div class="headline">住所</div>
                  <div class="input__text">
                    <span>{{ project.address }}</span>
                  </div>
                </div>
                <div class="content__input">
                  <div class="headline">道路規制</div>
                  <div class="input__text">
                    <span>{{ project.road_name }}</span>
                  </div>
                </div>
                <div class="content__input">
                  <div class="headline">備考</div>
                  <div class="input__text remark">
                    <span>{{ project.remark }}</span>
                  </div>
                </div>
                <!-- <template v-if="project.user.enable_sms === 1 && project.is_started === 0">
                    <div class="content__input">
                        <div class="headline attention any">担当者の携帯電話にSMSを送信</div>
                        <div class="content__confirmation">
                            <label class="checkbox__label">
                                送信する
                                <input type="checkbox" name="" v-model="project.is_send_to_charge">
                                <div class="checkbox__block"></div>
                            </label>
                        </div>
                    </div>
                </template> -->
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
                  <div class="headline">会社名</div>
                  <div class="input__text">
                    <span><a>{{ project.project_orderer.company }}</a></span>
                  </div>
                </div>
                <div class="content__input">
                  <div class="headline">会社名カナ</div>
                  <div class="input__text">
                    <span>{{ project.project_orderer.company_kana }}</span>
                  </div>
                </div>
                <template v-if="isViewer !== '1'">
                    <div class="content__input">
                    <div class="headline">郵便番号</div>
                    <div class="input__text">
                        <span>{{ project.project_orderer.zip }}</span>
                    </div>
                    </div>
                    <div class="content__input">
                    <div class="headline">住所</div>
                    <div class="input__text">
                        <span>{{ project.project_orderer.address }}</span>
                    </div>
                    </div>
                    <div class="content__input">
                    <div class="headline">代表者名</div>
                    <div class="input__text">
                        <span>{{ project.project_orderer.president }}</span>
                    </div>
                    </div>
                    <div class="content__input">
                    <div class="headline">代表者名カナ</div>
                    <div class="input__text">
                        <span>{{ project.project_orderer.president_kana }}</span>
                    </div>
                    </div>
                    <div class="content__input">
                    <div class="headline">電話番号</div>
                    <div class="input__text">
                        <span>{{ project.project_orderer.tel }}</span>
                    </div>
                    </div>
                    <div class="content__input">
                    <div class="headline">ファックス</div>
                    <div class="input__text">
                        <span>{{ project.project_orderer.fax }}</span>
                    </div>
                    </div>
                    <div class="content__input">
                    <div class="headline">携帯電話</div>
                    <div class="input__text">
                        <span>{{ project.project_orderer.phone }}</span>
                    </div>
                    </div>
                    <div class="content__input">
                    <div class="headline">メールアドレス</div>
                    <div class="input__text">
                        <span>{{ project.project_orderer.email }}</span>
                    </div>
                    </div>
                    <div class="content__input">
                    <div class="headline">備考</div>
                    <div class="input__text remark">
                        <span>{{ project.project_orderer.remark }}</span>
                    </div>
                    </div>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import axios from './../../utilities/axios'
    import errorHandling from './../../utilities/handling'
    import Modal from '../common/Modal.vue'
    import VueClipboard from 'vue-clipboard2'
    Vue.use(VueClipboard);
    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        components: {
            'modal' : Modal
        },
        props: {
            id: {
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
                project: '',
                message: '',
                copyMessage: 'コピーしました。'
            }
        },
        components: {
            // modal
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            // 案件情報を取得
            axios.get('/api/projects/' + this.id, {})
                .then(result => {
                    this.project = result.data
                })
                .catch(result => {
                    alert('案件情報の取得に失敗しました。')
                })
        },
        computed: {
            // 必要に応じてメソッドを定義
            url_fin: function() {
                return '/progress/' + this.id + '/report'
            },
            url_progress: function() {
                return process.env.MIX_API_BASE_URL + '/progress/' + this.id
            },
            url_survey: function() {
                if (this.project.is_surveyed) {
                    return this.urlPrefix + '/projects/survey/' + this.project.survey.id + '/detail'
                }
                return this.urlPrefix + '/projects/survey/' + this.id
            },
            url_advance_notice: function() {
                return this.urlPrefix + '/projects/advance-notice/' + this.id
            },
            url_edit: function() {
                return this.urlPrefix + '/projects/edit/' + this.id
            },
            url_line_with_orderer: function() {
                if (!this.project) return ''
                return this.line_url + this.line_message + '?is_open=1'
            },
            url_line_without_orderer: function() {
                return this.line_url + this.line_message
            },
            line_url: function() {
                return 'https://line.me/R/msg/text/?'
            },
            line_message: function() {
                return 'お疲れ様です。現場の詳細になります。安全作業でよろしくお願いします。' + this.url_progress
            },
            new_line_url_open: function() {
              return 'http://line.me/R/msg/text/?お疲れ様です。現場の詳細になります。安全作業でよろしくお願いします。' + process.env.MIX_API_BASE_URL + '/progress/' + this.id + '?is_open=1'
            },
            new_line_ur: function() {
              return 'http://line.me/R/msg/text/?お疲れ様です。現場の詳細になります。安全作業でよろしくお願いします。' + process.env.MIX_API_BASE_URL + '/progress/' + this.id
            },
        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義

            // ボタン押下時、確認メッセージを表示する
            confirm: function() {
                if (this.project.project_type === 0) {
                    this.message = '未解体・解体のスケジュールも削除されますが、よろしいでしょうか？'
                } else if ((this.project.project_type === 1) || (this.project.project_type === 2)) {
                    this.message = '架設のスケジュールも削除されますが、よろしいでしょうか？'
                }
                this.$refs.modal.openModal()
            },
            // 案件を削除する
            deleteProject: function() {
                // OKボタンが押下された場合、案件削除APIを呼び出す
                axios.delete('/api/projects/' + this.id, {})
                    .then(result => {
                        alert('案件を削除しました。')
                        // 削除後、カレンダーへ戻る
                        location.href = this.urlPrefix + '/calendar'
                    })
                    .catch(result => {
                        errorHandling.errorMessage(result)
                    })
            },
            // URLをコピーする(元請け情報あり)
            copyUrlWithOrderer: function() {
                let str = this.url_progress + '?is_open=1'
                this.$copyText(str).then(function (e) {
                    alert('URLをコピーしました。')
                }, function (e) {
                    alert('コピーできませんでした。運営者へお問い合わせくださいませ。')
                })
            },
            // URLをコピーする(元請け情報なし)
            copyUrlWithoutOrderer: function() {
                let str = this.url_progress
                this.$copyText(str).then(function (e) {
                    alert('URLをコピーしました。')
                }, function (e) {
                    alert('コピーできませんでした。運営者へお問い合わせくださいませ。')
                })
            },
            // LINEでメッセージ送信する
            sendToLine: function(mode) {
                // 案件情報を更新する
                axios.post('/api/projects/line/'+this.id, {})
                    .then(result => {
                    })
                    .catch(result => {
                        errorHandling.errorMessage(result)
                    })
                // LINEを新しいタブで開く
                if (mode === 'with_orderer') {
                    window.open(this.url_line_with_orderer, '_blank')
                } else {
                    window.open(this.url_line_without_orderer, '_blank')
                }
            },
            // 作業開始する
            start: function() {
                let str
                if (this.project.is_send_to_charge === 1) {
                    str = '元請け及び担当者にメッセージが送信されますが、よろしいでしょうか。'
                } else {
                    str = '元請けにメッセージが送信されますが、よろしいでしょうか。'
                }
                if (confirm(str)) {
                    // 案件情報を更新する
                    axios.post('/api/progress/start/'+this.id, {})
                        .then(result => {
                            alert('作業開始を行いました。作業終了時は、[作業終了]ボタンを押してください。')
                            location.reload()
                        })
                        .catch(result => {
                            errorHandling.errorMessage(result)
                        })
                }
            },

        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
