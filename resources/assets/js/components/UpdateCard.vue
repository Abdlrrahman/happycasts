<template>
  <div>
    <button class="btn btn-success" @click="update">Update card details</button>
  </div>
</template>

<script>
import Swal from "sweetalert";
import axios from "axios";
export default {
  props: ["email"],
  mounted() {
    this.handler = StripeCheckout.configure({
      key: "pk_test_2VnQL9Cic4hLPeiYtvHellBI",
      image: "https://stripe.com/img/documentation/checkout/marketplace.png",
      locale: "auto",
      allowRememberMe: false,
      token(token) {
        Swal({
          text: "Please wait for your order to get processed",
          buttons: false,
        });
        axios
          .post("/card/update", {
            stripeToken: "tok_mastercard_debit",
          })
          .then((resp) => {
            Swal({
              text: "Updated the card details successfully",
              icon: "success",
            }).then(() => {
              window.location = "";
            });
          });
      },
    });
  },
  data() {
    return {
      handler: null,
    };
  },
  methods: {
    update() {
      this.handler.open({
        name: "HappyCasts",
        description: "HappyCasts Subscription",
        email: this.email,
        panelLabel: "Update card details",
      });
    },
  },
};
</script>