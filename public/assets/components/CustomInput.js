export default {
    name: "custominput",
    props: ["name", "label", "type", "value", "feedback"],
    template: `
      <div class="form-group input-groupp row">
        <label :for="name" class="col-sm-3 col-form-label-lg p-1">{{ label }}</label>
        <div class="col-sm-9">
          <input :type="type" v-model="inputValue" class="form-control" :id="name" :placeholder="label" required>

          <div class="feedback">
            {{ feedback }}
          </div>
        </div>
      </div>
      `,
    computed: {
      inputValue: {
        get() {
          return this.value
        },
        set(value) {
          this.$emit("update-value", this.name, value)
        }
      }
    }
};
  