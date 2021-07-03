<template>
    <div>
        <template v-for="project in projects">
            <div class="content__box common__list">
                <div class="content__box__inner">
                    <a :href="`${urlPrefix}/calendar/yetproject/register/${project.id}`">
                        <div class="common__list__head">
                            <div class="supplement">
                                <span class="sub">{{ project.time_type_name }}・{{ project.project_type_name }}</span>
                                /
                                <span class="charge" v-if="project.charge">{{ project.charge.name }}</span>
                                <span class="charge" v-else>未定</span>
                            </div>
                            <div style="display:table; width:100%;">
                                <div class="title" style="display:table-cell;">
                                    <span>{{ project.name }}</span>
                                </div>
                                <div class="spent_date" style="display:table-cell; text-align:right;">
                                    <span class="colorRed bold">経過日数 {{ diffInDays(project.created_at) }}日</span>
                                </div>
                            </div>
                            <ul class="flex__wrap f__start status">
                                <li :class="{done: project.is_surveyed}"><span>現調</span></li>
                                <li :class="{done: project.is_notified}"><span>前日</span></li>
                                <li :class="{done: project.is_started}"><span>開始</span></li>
                                <li :class="{done: project.is_finished}"><span>終了</span></li>
                                <li><a :href="`https://www.google.com/maps/search/?api=1&query=${project.address}`" target="_blank" rel="noopener">MAP</a></li>
                            </ul>
                        </div>
                    </a>
                    <div class="common__list__body">
                        <ul class="others">
                            <li class="address bgCenterCover">{{ project.address }}</li>
                            <li class="company bgCenterCover">{{ project.project_orderer.company }}</li>
                            <li class="phone bgCenterCover">{{ project.project_orderer.tel }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    import axios from './../../utilities/axios'
    import errorHandling from './../../utilities/handling'
    import format from 'date-fns/format'
    import differenceInCalendarDays from 'date-fns/differenceInCalendarDays'

    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        props: ['isCharge', 'isViewer', 'urlPrefix'],
        data() {
            // 必要に応じて変数を定義
            return {
                projects: [],
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            // 未解体案件情報を取得
            const params = {
                project_type: [1],
            }
        axios.get('/api/projects', params)
            .then(result => {
                // 取得成功時：一覧へ反映
                this.projects = []
                this.projects = result.data
            })
            .catch(result => {
                // エラー時：アラートを表示
                alert('案件情報取得時にエラーが発生しました。')
            })
        },
        computed: {
            // 必要に応じてメソッドを定義

        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義
            // 経過日数を取得
            diffInDays: function(createdAt) {
                const nowDate          = new Date()
                const splitedCreatedAt = createdAt.split('-')
                const createdAtDate    = new Date(splitedCreatedAt[0], Number(splitedCreatedAt[1]) - 1, splitedCreatedAt[2])
                return differenceInCalendarDays(nowDate, createdAtDate)
            }
        },

        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
