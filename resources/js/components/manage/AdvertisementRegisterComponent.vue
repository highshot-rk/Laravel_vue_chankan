
<template>
    <div class="allWrapper">
        <modal ref="modal" @parentMethod="registerAdvertisement">
            <template v-slot:message>登録します。よろしいでしょうか？</template>
            <template v-slot:ok>OK</template>
            <template v-slot:cancel>戻る</template>
        </modal>
        <div class="content__wrap">
            <div class="content__section">

                <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1">広告会社追加</h1>
                        <span class="en">Add Register</span>
                    </div>
                </div>

                <div class="content__floar">
                    <div class="content__floar__inner">
                        <div class="content__box">
                            <div class="content__box__inner">
                                <div class="content__input">
                                    <div class="headline">会社名</div>
                                    <div class="input__box">
                                        <input class="bgType" type="text" name="" v-model="advertisement.company">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">URL</div>
                                    <div class="input__box">
                                        <input class="bgType" type="text" name="" v-model="advertisement.url">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="input__img flex__wrap">
                                        <div class="input__img__block">
                                            <div class="input__img__block__inner containImg">
                                                <img :src="thumbImg">
                                            </div>
                                            <div class="input__delete" :class="{get: getImg}" @click="deleteItem">
                                                <span><img src="/assets/img/icon_batu_white.png"></span>
                                            </div>
                                        </div>
                                        <div class="input__img__label v__center flex__wrap">
                                            <label>
                                                <span>画像を追加</span>
                                                <input type="file" ref="file" class="avatar_name" accept="image/jpeg, image/png, application/pdf" @change="setImage">
                                            </label>
                                        </div>
                                    </div>
                                </div>

                               <!--  <div class="content__input">
                                    <div class="headline">広告画像</div>
                                    <div class="input__img__block">
                                        <div class="input__img__block__inner containImg">
                                            <img :src="thumbImg">
                                        </div>
                                        <div class="input__delete" :class="{get: getImg}" @click="deleteItem">
                                            <span><img src="/assets/img/icon_batu_white.png"></span>
                                        </div>
                                    </div>
                                    <div class="input__img__label">
                                        <label>
                                            <span>アップロード</span>
                                            <input type="file" ref="file" class="avatar_name" accept="image/jpeg, image/png, application/pdf" @change="setImage">
                                        </label>
                                    </div>
                                </div> -->

                                    <!-- <div class="input__img flex__wrap v__center">

                                        <div class="input__img flex__wrap">
                                            <div class="input__img__block">
                                                <div class="input__img__block__inner containImg">
                                                    <img :src="thumbImg">
                                                </div>
                                                <div class="input__delete" :class="{get: getImg}" @click="deleteItem">
                                                    <span><img src="/assets/img/icon_batu_white.png"></span>
                                                </div>
                                            </div>
                                            <div class="input__img__label v__center flex__wrap">
                                                <label>
                                                    <span>アップロード</span>
                                                    <input type="file" ref="file" class="avatar_name" accept="image/jpeg, image/png, application/pdf" @change="setImage">
                                                </label>
                                            </div>
                                        </div>
                                    </div> -->

                                <div class="content__input">
                                    <div class="headline">電話番号</div>
                                    <div class="input__box">
                                        <input class="bgType" type="text" name="" v-model="advertisement.tel">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">担当者名</div>
                                    <div class="input__box">
                                        <input class="bgType" type="text" name="" v-model="advertisement.charge">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">メールアドレス</div>
                                    <div class="input__box">
                                        <input class="bgType" type="email" name="" v-model="advertisement.email">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">携帯電話</div>
                                    <div class="input__box">
                                        <input class="bgType" type="text" name="" v-model="advertisement.phone">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">郵便番号（※半角数字のみ入力可）</div>
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
                                    <div class="headline">住所</div>
                                    <div class="input__wrap">
                                        <div class="input__box">
                                            <input class="bgType" type="text" name="" v-model="advertisement.address">
                                        </div>
                                    </div>
                                </div>

                                <div class="content__input">
                                    <div class="headline">契約期間</div>
                                    <div class="input__wrap">
                                        <div class="input__box selectBox">
                                            <select class="bgType" name="" v-model="contract.period">
                                                <option value="1ヶ月">1ヶ月</option>
                                                <option value="3ヶ月">3ヶ月</option>
                                                <option value="6ヶ月">6ヶ月</option>
                                                <option value="12ヶ月">12ヶ月</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">金額（※ 半角数字のみご記入ください）</div>
                                    <div class="input__wrap">
                                        <div class="input__box">
                                            <input class="bgType" type="number" name="" v-model="contract.price">
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
                    <button class="clickonce" type="button" @click="confirm">広告出稿</button>
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
        props: {},
        data() {
            // 必要に応じて変数を定義
            return {
                advertisement: {
                    company: '',
                    tel:     '',
                    url:     '',
                    charge:  '',
                    email:   '',
                    phone:   '',
                    zip:     '',
                    address: '',
                },
                zip_first:   '',
                zip_second:  '',
                contract: {
                    period:  '',
                    price:   '',
                },
                image:    null,
                thumbImg: '/assets/img/noImage.png',
                getImg:   false
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
        },
        computed: {
            // 必要に応じてメソッドを定義

        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義

            setImage: function() {
                let file = this.$refs.file.files[0];
                // let fileImg = files.files[0]
                if (file.type.startsWith("image/")) {
                    // バツボタンを付与
                    this.getImg = true
                    // 画像を変更
                    this.thumbImg = window.URL.createObjectURL(file)
                    this.image    = file
                }
            },
            deleteItem: function() {
                this.getImg   = false
                this.thumbImg = '/assets/img/noImage.png'
                this.image    = null
            },
            // ボタン押下時、確認メッセージを表示する
            confirm: function() {
                this.$refs.modal.openModal()
            },
            // 広告会社情報を登録する
            registerAdvertisement: function() {
                // OKボタンが押下された場合、広告会社更新APIを呼び出す
                let formData = new FormData()
                this.advertisement.zip = this.zip_first + this.zip_second
                formData.append('advertisement[company]', this.advertisement.company)
                formData.append('advertisement[tel]',     this.advertisement.tel)
                formData.append('advertisement[url]',     this.advertisement.url)
                formData.append('advertisement[charge]',  this.advertisement.charge)
                formData.append('advertisement[email]',   this.advertisement.email)
                formData.append('advertisement[phone]',   this.advertisement.phone)
                formData.append('advertisement[zip]',     this.advertisement.zip)
                formData.append('advertisement[address]', this.advertisement.address)
                formData.append('contract[period]',       this.contract.period)
                formData.append('contract[price]',        this.contract.price)
                formData.append('image',                  this.image)

                // OKボタンが押下された場合、広告会社更新APIを呼び出す
                // let formData = new FormData()
                // this.advertisement.zip = this.zip_first + this.zip_second
                // formData.append('advertisement', JSON.stringify(this.advertisement))
                // formData.append('contract',      JSON.stringify(this.contract))
                // formData.append('image',         this.image)

                let config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                axios.post('/api/advertisements', formData, config)
                    .then(result => {
                        location.href = '/clients/ads/new/complete'
                    })
                    .catch(result => {
                        errorHandling.errorMessage(result)
                    })
            },
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
