<template>
    <div class="allWrapper">
        <div class="content__wrap">
            <div class="content__section">

                <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1">{{ project.name }}</h1>
                        <span class="en">Project Detail</span>
                    </div>
                </div>
                <div class="content__success" v-if="project.is_started === 1">
                  <p>作業開始報告メッセージが、営業担当及び元請けに送られました。<br>作業終了時は、「作業終了」ボタンを押してください。</p>
                </div>
                <div class="content__signal" v-if="project.is_finished === 0">
                    <ul class="flex__wrap">
                        <li v-if="project.is_started === 0"><a @click.prevent="start">作業開始</a></li>
                        <li v-if="project.is_started === 0" class="notClick" disabled><a>作業終了</a></li>
                        <li v-if="project.is_started === 1" class="notClick" disabled><a>作業開始</a></li>
                        <li v-if="project.is_started === 1"><a :href="url_fin">作業終了</a></li>
                    </ul>
                </div>
                <div class="content__floar">
                    <div class="content__floar__inner">
                        <div class="content__box">
                            <div class="content__box__inner">
                                <div class="content__input">
                                    <div class="headline">現場調査</div>
                                    <div class="input__text">
                                        <a class="textLink" v-if="project.survey" :href="project.survey.url">https://cattobi.com{{ project.survey.url }}</a>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">営業担当</div>
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
                                        <span>〒{{ project.zip }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">住所</div>
                                    <div class="input__text">
                                        <a class="textLink" :href="`https://www.google.com/maps/search/?api=1&query=${project.address}`" target="_blank" rel="noopener">{{ project.address }}</a>
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
                                <div class="content__input" v-if="isOpen == 1">
                                    <div class="headline">元請け会社</div>
                                    <div class="input__text">
                                        <span>{{ project.project_orderer.company }}</span>
                                    </div>
                                </div>
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

    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        props: ['id', 'isOpen'],
        data() {
            // 必要に応じて変数を定義
            return {
                project: null,
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義

            // 案件情報を取得
            axios.get('/api/projects/'+this.id, {})
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
            }
        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義

            // 作業開始する
            start: function() {
                if (confirm('営業担当と元請けにメッセージが送信されますが、よろしいでしょうか。')) {
                    // 案件情報を更新する
                    axios.post('/api/progress/start/'+this.id, {})
                        .then(result => {
                            // TODO:画面上部のメッセージ表示を行う形に差し替える
                            alert('作業開始を行いました。作業終了時は、[作業終了]ボタンを押してください。')
                            location.href = '/progress/' + this.id + '?is_open=1'
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
