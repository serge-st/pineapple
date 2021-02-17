const app = new Vue({
    el: '#root',
    data: {
        heading: "Subscribe to newsletter",
        paragraph: "Subscribe to our newsletter and get 10% discount on pineapple glasses.",
        trophyImage: "../static/images/ic_success.svg",
        isSubmissionSuccessful: true,
    }

});


const successHeading = "Thanks for subscribing!";
const successParagraph = "You have successfully subscribed to our email listing. Check your email for the discount code.";

// don't forget to add .main-success class to main in Task 2