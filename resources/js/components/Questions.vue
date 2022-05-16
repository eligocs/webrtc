<template>
  <div class="main-questions">
    <div class="myQuestion" v-for="(question, index) in questions" v-bind:key="index">
      <div class="row">
        <div class="col-md-12">
          <blockquote>Total Questions &nbsp;&nbsp;{{ index+1 }} / {{questions.length}}</blockquote>
          <h2 class="question" style="font-size: 17.5px;">Q. &nbsp;{{question.question}}</h2>
          <div class="row" v-if="question.code_snippet !== null">
            <div class="col-md-10">
              <pre class="code">
                {{question.code_snippet}}
              </pre>
            </div>
          </div>
          <form
            class="myForm"
            action="/quiz_start"
            v-on:submit.prevent="createQuestion(question.id, question.answer, auth.id, question.topic_id)"
            method="post"
          >
            <div>
              <!-- <div class="qustn-slct"> -->
              <!-- <div class=""> -->
              <label class="qustn-slct border-gradient-orange" v-bind:for="'radio'+ index">
                <input
                  class="radioBtn"
                  v-bind:id="'radio'+ index"
                  type="radio"
                  v-model="result.user_answer"
                  value="A"
                  aria-checked="false"
                />
                A. &nbsp;
                {{question.a}}
              </label>
              <br />
              <!-- </div> -->
              <!-- <div class="qustn-slct"> -->
              <!-- <div class=""> -->
              <label class="qustn-slct border-gradient-pink" v-bind:for="'radio'+ index+1">
                <input
                  class="radioBtn"
                  v-bind:id="'radio'+ index+1"
                  type="radio"
                  v-model="result.user_answer"
                  value="B"
                  aria-checked="false"
                />
                B. &nbsp;
                {{question.b}}
              </label>

              <br />
              <!-- <div class="qustn-slct"> -->
              <!-- <div class=""> -->
              <label class="qustn-slct border-gradient-blue" v-bind:for="'radio'+ index+2">
                <input
                  class="radioBtn"
                  v-bind:id="'radio'+ index+2"
                  type="radio"
                  v-model="result.user_answer"
                  value="C"
                  aria-checked="false"
                />
                C. &nbsp;
                {{question.c}}
              </label>

              <br />
              <!-- <div class="qustn-slct"> -->
              <!-- <div class=""> -->
              <label class="qustn-slct border-gradient-green" v-bind:for="'radio'+ index+3">
                <input
                  class="radioBtn"
                  v-bind:id="'radio'+ index+3"
                  type="radio"
                  v-model="result.user_answer"
                  value="D"
                  aria-checked="false"
                />
                D. &nbsp;
                {{question.d}}
              </label>

              <br />
            </div>
            <div class="row">
              <div class="col-md-6 col-12 d-flex flex-wrap justify-content-between">
                <!-- <button type="submit" class="btn btn-theme btn-block nextbtn">Next</button> -->
                <button
                  type="button"
                  class="btn-block pink-gradient py-2 mx-0 no-border mw-220 text-center text-white prebtn"
                  v-if="index+1 > 1"
                >Previous</button>
                <button
                  type="submit"
                  class="btn-block pink-gradient py-2 mx-0 no-border mw-220 text-center text-white nextbtn"
                >Next</button>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-md-3 col-8">
                <button type="submit" class="btn btn-theme btn-block nextbtn ">Next</button>
              </div>
            </div>-->
          </form>
        </div>
        <div class="col-md-6">
          <div
            class="question-block-tabs"
            v-if="question.question_img != null || question.question_video_link != null"
          >
            <ul class="nav nav-tabs tabs-left">
              <li v-if="question.question_img != null" class="active">
                <a href="#image" data-toggle="tab">Question Image</a>
              </li>
              <li v-if="question.question_video_link != null">
                <a href="#video" data-toggle="tab">Question Video</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="image" v-if="question.question_img != null">
                <div class="question-img-block">
                  <img
                    :src="'/storage/'+question.question_img"
                    class="img-responsive"
                    alt="question-image"
                  />
                </div>
              </div>
              <div class="tab-pane fade" id="video" v-if="question.question_video_link != null">
                <div class="question-video-block">
                  <h3 class="question-block-heading">Question Video</h3>
                  <iframe
                    :id="'video'+(index+1)"
                    width="460"
                    height="345"
                    :src="question.question_video_link"
                    frameborder="0"
                    allowfullscreen
                  ></iframe>
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
export default {
  props: ["topic_id"],

  data() {
    return {
      questions: [],
      answers: [],
      result: {
        question_id: "",
        answer: "",
        user_id: "",
        user_answer: 0,
        topic_id: "",
      },
      auth: [],
    };
  },

  created() {
    this.fetchQuestions();
  },

  methods: {
    fetchQuestions() {
      this.$http
        .get(
          `/student/start_quiz/${this.$props.topic_id}/quiz/${this.$props.topic_id}`
        )
        .then((response) => {
          this.questions = response.data.questions;
          this.auth = response.data.auth;
        })
        .catch((e) => {
          console.log(e);
        });
    },

    createQuestion(id, ans, user_id, topic_id) {
      this.result.question_id = id;
      this.result.answer = ans;
      this.result.user_id = user_id;
      this.result.topic_id = this.$props.topic_id;
      this.$http
        .post(`/student/start_quiz/${this.$props.topic_id}/quiz`, this.result)
        .then((response) => {
          console.log("request completed");
        })
        .catch((e) => {
          console.log(e);
        });
      this.result.user_answer = 0;
      this.result.topic_id = "";
    },
  },
};
</script>