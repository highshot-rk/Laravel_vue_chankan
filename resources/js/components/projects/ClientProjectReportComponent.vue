<template>
    <div class="allWrapper">
        <modal ref="modal" @parentMethod="fin">
            <template v-slot:message>作業終了報告をします。よろしいでしょうか？</template>
            <template v-slot:ok>OK</template>
            <template v-slot:cancel>戻る</template>
        </modal>
        <div class="content__wrap">
            <div class="content__section">
                <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1">作業終了報告</h1>
                        <span class="en">Complete Report</span>
                    </div>
                </div>

                <div class="content__floar">
                    <div class="content__floar__inner">
                        <div class="content__box">
                            <div class="content__box__inner">
                                <div class="content__upload">
                                    <p>施工後の写真を送る場合は、画像をアップロードしてください。</p>
                                </div>

                                <!-- <div class="content__input">
                                    <div class="input__img flex__wrap v__center">
                                        <div class="input__img__block containImg">
                                            <img src="/assets/img/258615_s.jpg" alt="">
                                        </div>
                                        <div class="input__img__label">
                                            <div class="input__img__label v__center flex__wrap"><label><span>画像を選択</span><input type="file" ref="file" class="finish_img" accept="image/jpeg, image/png, application/pdf"></label></div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="content__input">
                                    <div class="input__img flex__wrap">
                                        <div class="input__img__block">
                                            <div class="input__img__block__inner containFlexImg"
                                                @dragenter="dragEnter"
                                                @dragleave="dragLeave"
                                                @dragover.prevent
                                                @drop.prevent="dropFile"
                                                :class="{enter: isEnter}">
                                                <img :src="thumbImg">
                                            </div>
                                            <div class="input__delete"
                                                    :class="{get: getImg}"
                                                    @click="deleteItem">
                                                <span><img src="/assets/img/icon_batu_white.png"></span>
                                            </div>
                                        </div>
                                        <div class="input__img__label v__center flex__wrap">
                                            <label>
                                                <span>画像を選択</span>
                                                <input type="file" ref="file" class="avatar_name" accept="image/jpeg, image/png, application/pdf" @change="setImage">
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
                    <a href="" @click.prevent="fin">完了報告を送信</a>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import axios from './../../utilities/axios'
    import errorHandling from './../../utilities/handling'
    import Modal from '../common/Modal.vue'

    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        components: {
            'modal' : Modal
        },
        props: {
            id: {
                type: String
            },
        },
        data() {
            // 必要に応じて変数を定義
            return {
                image:　　null,
                thumbImg:'/assets/img/noImage.png',
                getImg:　false,
                isEnter: false,
                files: []
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義


        },
        computed: {
            // 必要に応じてメソッドを定義
            url_fin: function() {
                return '/progress/' + this.id + '/report'
            }
        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義

            // 画像をアップロードする
            setImage: function() {
                let file = this.$refs.file.files[0]
                if (file.type.startsWith("image/")) {
                    // バツボタンを付与
                    this.getImg = true
                    // 画像を変更
                    this.thumbImg = window.URL.createObjectURL(file)
                    this.image    = file
                }
            },
            // 画像を削除する
            deleteItem: function() {
                this.getImg   = false
                this.thumbImg = '/assets/img/noImage.png'
                this.image    = null
            },
            // ボタン押下時、確認メッセージを表示する
            confirm: function() {
                this.$refs.modal.openModal()
            },
            // 作業完了する
            fin: function() {
                // OKボタンが押下された場合、広告会社更新APIを呼び出す
                let formData = new FormData()
                formData.append('image', this.image)
                let config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                axios.post('/api/progress/fin/'+this.id, formData)
                    .then(result => {
                        // 更新後、完了画面へ遷移する
                        location.href = '/progress/'+ this.id +'/complete?is_finish_reported=1'
                    })
                    .catch(result => {
                        errorHandling.errorMessage(result)
                    })
            },
            // 画像がドロップエリアに入った場合
            dragEnter: function() {
                this.isEnter = true;
            },
            // 画像がドロップエリアから外れた場合
            dragLeave: function() {
                this.isEnter = false;
            },
            // 画像がドロップエリアに入った場合
            dragOver: function() {
                console.log('DragOver')
            },
            dropFile: function() {
                this.isEnter = false
                
                
                if (this.files.length > 1) {
                    return alert('アップロードできるファイルは1つだけです。')
                } else {
                    this.getImg = true
                    this.files = [...event.dataTransfer.files]
                    this.files.forEach(file => {
                            // let form = new FormData()
                            // form.append('file', file)
                            this.thumbImg = window.URL.createObjectURL(file)
                            this.image    = file
                            // axios.post('/url', form).then(response => {
                            //     console.log(ok)
                            // }).catch(error => {
                            //     console.log(error)
                            // })
                        })
                }
            }
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
