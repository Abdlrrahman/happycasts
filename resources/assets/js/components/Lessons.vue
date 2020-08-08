<template>
  <div class="container" style="color: black; font-weight: bold;">
    <h1 class="text-center">
      <button class="btn btn-primary" @click="createNewLesson()">Create New Lesson</button>
    </h1>
    <div class>
      <ul class="list-group d-flex">
        <li
          class="list-group-item d-flex justify-content-between"
          v-for="(lesson, key) in lessons"
          :key="key(lesson, key)"
        >
          <p>{{ lesson.title }}</p>
        </li>
      </ul>
    </div>
    <create-lesson></create-lesson>
  </div>
</template>

<script>
import Axios from "axios";
export default {
  props: ["default_lessons", "series_id"],
  mounted() {
    this.$on("lesson_created", (lesson) => {
      this.lessons.push(lesson);
    });
  },
  components: {
    "create-lesson": require("./children/CreateLesson.vue"),
  },
  data() {
    return {
      lessons: JSON.parse(this.default_lessons),
    };
  },
  computed: {},
  methods: {
    createNewLesson() {
      this.$emit("create_new_lesson", this.series_id);
    },
  },
};
</script>