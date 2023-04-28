import { Toasted } from "vue-toasted";
import Vue from "vue";

Vue.use(Toasted);
export const showValidationErrors = (errors) => {
  Object.entries(errors).forEach(([key, value]) => {
    // Toasted. .success({
    //   message: value[0],
    // });
    Vue.toasted.show(value[0]);
  });
};
