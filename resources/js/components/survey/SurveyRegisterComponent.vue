<template>
  <div class="allWrapper">
    <div class="content__wrap">
      <div class="content__section">
        <div class="content__header">
          <div class="content__title">
            <h1 class="h1">現場調査報告</h1>
            <span class="en">Survey</span>
          </div>
        </div>
        <div class="content__floar">
          <div class="content__floar__inner">
            <div class="content__box">
              <div class="content__box__inner">
                <!-- 複数読み込み -->
                <div
                  class="content__input"
                  v-for="(survey, index) in surveys"
                  v-bind:key="survey.id"
                >
                  <div class="input__img flex__wrap">
                    <div class="input__img__block">
                      <div class="input__img__block__inner containFlexImg"
                          @dragenter="dragEnter(index)"
                          @dragleave="dragLeave(index)"
                          @dragover.prevent
                          @drop.prevent="dropFile(index)"
                          :class="{enter: survey.isEnter}">
                        <img :src="survey.thumbImg" ref="thumbFile">
                      </div>
                      <div class="input__delete"
                        :class="{get: survey.getImg}"
                        @click="deleteItem(index)">
                        <span><img src="/assets/img/icon_batu_white.png"></span>
                      </div>
                    </div>
                    <div class="input__img__label v__center flex__wrap">
                      <label>
                        <span>{{ survey.status }}</span>
                        <input
                          type="file"
                          multiple="multiple"
                          ref="file"
                          class="avatar_name"
                          accept="image/jpeg, image/png, application/pdf"
                          @change="setImage(index)"
                        />
                      </label>
                    </div>
                  </div>

                  <div class="input__box" style="margin-top: 1em;">
                    <div class="headline attention any">画像についての説明</div>
                    <div class="input__box subText">
                      <textarea class="bgType" name v-model="survey.description"></textarea>
                    </div>
                  </div>
                </div>
                <div class="content__input">
                  <div class="headline attention any">備考</div>
                  <div class="input__box">
                    <textarea
                      class="bgType"
                      placeholder="南面が狭小の為、近隣に注意して作業してください。"
                      v-model="remark"
                    ></textarea>
                  </div>
                </div>
                <template v-if="enable_sms == '1'">
                  <div class="content__input">
                    <div class="headline attention any">元請けの携帯電話にSMSを送信</div>
                    <div class="content__confirmation">
                      <label class="checkbox__label">
                        送信する
                        <input type="checkbox" name v-model="is_send_to_project_orderer" />
                        <div class="checkbox__block"></div>
                      </label>
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="content__submit f__center">
        <div class="submit__box">
          <a href v-if="mode === 'register'" @click.prevent="storeSurvey">現調報告する</a>
          <a href v-if="mode === 'edit'" @click.prevent="updateSurvey">現調報告する</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "./../../utilities/axios";
import errorHandling from "./../../utilities/handling";

export default {
  props: {
    project_id: {
      type: String,
    },
    survey_id: {
      type: String,
    },
    mode: {
      type: String,
    },
    enable_sms: {
      type: String,
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
    return {
      surveys: [],
      is_send_to_project_orderer: false,
      remark: "",
      deleted_survey_image_ids: [],
    };
  },
  created: function () {
    // 編集モードの場合、調査情報を取得
    if (this.mode === "edit") {
      axios
        .get("/api/surveys/" + this.survey_id)
        .then((result) => {
          result.data.survey_images.forEach((surveyImage) => {
            // 調査情報を格納
            let item = {
              imageId: surveyImage.id,
              thumbImg: "/" + surveyImage.img,
              status: "画像を追加",
              getImg: true,
              isEnter: false,
              file: "file",
              description: surveyImage.description,
            };
            this.surveys.push(item);
          });
          // 空データを1つ、変数へ登録
          let emptyItem = {
            imageId: null,
            thumbImg: "/assets/img/noImage.png",
            status: "画像を追加",
            getImg: false,
            isEnter: false,
            file: "null",
            description: "",
          };
          this.surveys.push(emptyItem);
          // 備考を設定
          this.remark = result.data.remark
        })
        .catch((result) => {
          errorHandling.errorMessage(result);
        });
    } else {
      // 空データを1つ、変数へ登録
      let emptyItem = {
        imageId: null,
        thumbImg: "/assets/img/noImage.png",
        status: "画像を追加",
        getImg: false,
        isEnter: false,
        file: "null",
        description: "",
      };
      this.surveys.push(emptyItem);
    }
  },
  methods: {
    setImage: function (index) {
      let files = this.$refs.file[index];
      for (let i = 0; i < files.files.length; i++) {
        let fileImg = files.files[i];
        if (fileImg.type.startsWith("image/")) {
          // バツボタンを付与
          this.surveys[index + i].getImg = true;
          // 画像を変更
          this.surveys[index + i].thumbImg = window.URL.createObjectURL(
            fileImg
          );
          this.surveys[index + i].file = fileImg;
          var item = {
            imageId: null,
            thumbImg: "/assets/img/noImage.png",
            status: "画像を追加",
            getImg: false,
            isEnter: false,
            file: "null",
            description: "",
          };
          // 配列に要素を追加
          this.surveys.push(item);
        }
      }
    },
    deleteItem: function (index) {
      // idプロパティに値がある場合、削除対象として追加する
      if (this.surveys[index].imageId) {
          this.deleted_survey_image_ids.push(this.surveys[index].imageId)
      }
      this.surveys.splice(index, 1);
    },
    // 画像がドロップエリアに入った場合
    dragEnter: function (index) {
      this.surveys[index].isEnter = true;
    },
    // 画像がドロップエリアから外れた場合
    dragLeave: function (index) {
      this.surveys[index].isEnter = false;
    },
    // ドラッグ＆ドロップ時の画像アップロード処理(複数枚に対応)
    dropFile: function (index) {
      let tempFiles = [...event.dataTransfer.files];
      let isOverwrite = this.surveys[index].getImg;
      for (let i = 0; i < tempFiles.length; i++) {
        // surveys[]に追加する要素を生成
        let item = {
          imageId: null,
          thumbImg: window.URL.createObjectURL(tempFiles[i]),
          status: "画像を追加",
          getImg: true,
          isEnter: false,
          file: tempFiles[i],
          description: "",
        };
        // (1枚目の画像の場合のみ処理)既に同エリアに画像アップ済の場合、上書きする
        if (isOverwrite && i === 0) {
          this.surveys[index] = item;
        } else if (isOverwrite) {
          // 画像アップ済の場合、差し込み
          this.surveys.splice(index + i, 0, item);
        } else {
          if (i === 0) {
            this.deleteItem(index);
          }
          // 画像未アップの場合、末尾のひとつ手前に追加
          this.surveys.push(item);
        }
      }
      // 新規のアップロード領域を追加する
      if (!isOverwrite) {
        let item = {
          imageId: null,
          thumbImg: "/assets/img/noImage.png",
          status: "画像を追加",
          getImg: false,
          isEnter: false,
          file: "null",
          description: "",
        };
        this.surveys.push(item);
      }
    },
    // 現地調査を登録
    storeSurvey: function () {
      let formData = new FormData();
      let fileCount = 0
      this.surveys.forEach((survey) => {
        formData.append("descriptions[]", survey.description);
        formData.append("images[file][]", survey.file);
        if (survey.file != "null") {
          fileCount++
        }
      });
      if (fileCount <= 0) {
          alert("報告書が作成されてないので送信できません。")
          return 0
      }
      formData.append(
        "is_send_to_project_orderer",
        this.is_send_to_project_orderer
      );
      formData.append("remark", this.remark);
      formData.append("project_id", this.project_id);
      let config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };
      axios
        .post("/api/surveys", formData, config)
        .then((result) => {
          // 登録後、完了画面へ遷移
          location.href = this.urlPrefix + "/projects/survey/" + this.project_id + "/complete";
        })
        .catch((result) => {
          errorHandling.errorMessage(result);
        });
    },
    // 現地調査を更新
    updateSurvey: function () {
      let formData = new FormData();
      let funcs    = [];
      this.surveys.forEach((survey, index) => {
        formData.append("image_ids[]", survey.imageId);
        formData.append("descriptions[]", survey.description);
        formData.append("images[file][]", survey.file);
        if (typeof (survey.file) == "object") {
            formData.append("images[is_uploaded][]", true);
        } else {
            formData.append("images[is_uploaded][]", false);
        }
      });
      formData.append(
        "is_send_to_project_orderer",
        this.is_send_to_project_orderer
      );
      formData.append("remark", this.remark);
      this.deleted_survey_image_ids.forEach((deleted_survey_image_id) => {
          formData.append("deleted_survey_image_ids[]", deleted_survey_image_id);
      });
      let config = {
        headers: {
          "content-type": "multipart/form-data",
          "X-HTTP-Method-Override": "PUT",
        },
      };
      axios
        .post("/api/surveys/" + this.survey_id, formData, config)
        .then((result) => {
          alert("現地調査情報を更新しました。");
          // 更新後、一覧へ遷移
          history.back(-1);
        })
        .catch((result) => {
          errorHandling.errorMessage(result);
        });
    },
  },
};
</script>
