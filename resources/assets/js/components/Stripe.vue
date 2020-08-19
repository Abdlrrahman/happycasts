<template>
  <div>
    <button class="btn btn-success" @click="subscribe('monthly')">Subscribe to $9.99 Monthly</button>
    <button class="btn btn-info" @click="subscribe('yearly')">Subscribe to $99.9 Yearly</button>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert";
export default {
  props: ["email"],
  mounted() {
    this.handler = StripeCheckout.configure({
      key:
        "key",
      image: "https://stripe.com/img/documentation/checkout/marketplace.png",
      locale: "auto",
      token(token) {
        Swal({
          text: "Please wait for your order to get processed",
          buttons: false,
        });
        axios
          .post("/subscribe", {
            stripeToken: token.id,
            plan: window.stripePlan,
          })
          .then((resp) => {
            Swal({ text: "subscribed successfully", icon: "success" }).then(
              () => {
                window.location = "";
              }
            );
          })
          .catch((error) => {
            console.log(error);
          });
      },
    });
  },
  data() {
    return {
      plan: "",
      amount: 0,
      handler: null,
    };
  },
  methods: {
    subscribe(plan) {
      if (plan == "monthly") {
        window.stripePlan = "monthly";
        this.amount = 999;
      } else {
        window.stripePlan = "yearly";
        this.amount = 9999;
      }
      this.handler.open({
        name: "HappyCasts",
        description: "HappyCasts Subscription",
        amount: this.amount,
        email: this.email,
      });
    },
  },
};
</script>