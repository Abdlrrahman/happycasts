<template>
  <div>
    <div :data-vimeo-id="lesson.video_id" data-vimeo-width="900" v-if="lesson" id="handstick"></div>
  </div>
</template>

<script>
import Player from "@vimeo/player";
import Swal from "sweetalert";

export default {
  props: ["default_lesson", "next_lesson_url"],

  methods: {
    displayVideoEndedAlert() {
      if (this.next_lesson_url) {
        Swal("Congrats You completed this lesson !").then(() => {
          window.location = this.next_lesson_url;
        });
      } else {
        Swal("Congrats You completed this series !");
      }
    },
  },

  data() {
    return {
      lesson: JSON.parse(this.default_lesson),
    };
  },

  mounted() {
    const player = new Player("handstick");

    player.on("ended", () => {
      this.displayVideoEndedAlert();
    });
  },
};
</script>