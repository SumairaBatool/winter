// <!-- qcslider -->
    $(document).ready(function ($) {
        $("#slider").QCslider({
            duration: 2000
        });
    

// <!-- login form slefstyle-->

$("#login-pop").click(function(){
    $("#popup").addClass("openpopup")

})
    // let popup=document.getElementById("popup");
    // function openpopup(){
    //    popup.classList.add("openpopup");
    // }

    // login crosse icon handle
    $('#hideform').click(function(){
        $("#popup").fadeOut().removeClass("openpopup");
       
    })
})

  // <!-- form validation -->
    $(document).ready(function () {
        $("#form-validate").submit(function () {
            // User fullname validation
            let userName = $("#fulname").val();
            let namepattren = /^[A-Za-z ]+$/;

            if (userName === "") {
                $(".show-fulname-error").html("**Name is required").addClass("name-error");
                return false;
            } else if (!namepattren.test(userName)) {
                $(".show-fulname-error").html("Name should be contain only charecter").addClass("name-error");
                return false;
            } else {
                $(".show-fulname-error").hide();
                $("#fulname").addClass("validation-success-name");
            }

            // Password validation
            let userpass = $("#password").val();
            let passpattren= /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;

            if (userpass == "") {
                $(".show-password-error").html("**Password is required").addClass("password-error");
                return false;
            } 
             else if (!passpattren.test(userpass)) {
                $(".show-password-error").html("Password not matched!").addClass("password-error");
                return false;
            } 
            else {
                $(".show-password-error").hide();
                $("#password").addClass("validation-success-pass");
            }
            // All validations passed, continue with form submission
            return true;
        });
    });

// scroll up functions


            // Parse URL Queries Method
            (function ($) {
                $.getQuery = function (query) {
                    query = query.replace(/[\[]/, '\\\[').replace(/[\]]/, '\\\]');
                    var expr = '[\\?&]' + query + '=([^&#]*)';
                    var regex = new RegExp(expr);
                    var results = regex.exec(window.location.href);
                    if (results !== null) {
                        return results[1];
                    } else {
                        return false;
                    }
                };
            })(jQuery);

            $(function () {

                // Set theme based on URI
                if ($.getQuery('theme') === 'pill') {
                    $(function () {
                        $.scrollUp({
                            animation: 'fade',
                            activeOverlay: '#00FFFF'
                        });
                    });
                    $('.pill-switch').addClass('active');
                    $('#scrollUpTheme').attr('href', 'css/themes/pill.css?1.1');
                } else if ($.getQuery('theme') === 'link') {
                    $(function () {
                        $.scrollUp({
                            animation: 'fade',
                            activeOverlay: '#00FFFF'
                        });
                    });
                    $('#scrollUpTheme').attr('href', 'css/themes/link.css?1.1');
                    $('.link-switch').addClass('active');
                } else if ($.getQuery('theme') === 'image') {
                    $(function () {
                        $.scrollUp({
                            animation: 'fade',
                            activeOverlay: '#00FFFF',
                            scrollImg: {
                                active: true,
                                type: 'background',
                                src: 'img/top.png'
                            }
                        });
                    });
                    $('#scrollUpTheme').attr('href', 'css/themes/image.css?1.1');
                    $('.image-switch').addClass('active');
                } else {
                    $(function () {
                        $.scrollUp({
                            animation: 'slide',
                            activeOverlay: '#00FFFF'
                        });
                    });
                    $('#scrollUpTheme').attr('href', 'css/themes/tab.css?1.1');
                    $('.tab-switch').addClass('active');
                }

       
            });
            $(function () {
                $.scrollUp({
                  scrollName: 'scrollUp', // Element ID
                  topDistance: '100', // Distance from top before showing element (px)
                  topSpeed: 300, // Speed back to top (ms)
                  animation: 'fade', // Fade, slide, none
                  animationInSpeed: 200, // Animation in speed (ms)
                  animationOutSpeed: 200, // Animation out speed (ms)
                  scrollText: '', // Text for element
                  activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
                });
              });
            //login form validation
              document.addEventListener("DOMContentLoaded", function () {
                  const form = document.querySelector(".validation-form");
      
                  const emailInput = document.getElementById("email");
                  const passwordInput = document.getElementById("password");
      
      
                  const emailError = document.getElementById("email-error");
                  const passwordError = document.getElementById("password-error");
      
      
                  form.addEventListener("submit", function (event) {
                      let isValid = true;
      
      
                      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                      if (!emailRegex.test(emailInput.value)) {
                          emailInput.classList.add("invalid");
                          emailError.classList.add("visible");
                          isValid = false;
                      } else {
                          emailInput.classList.remove("invalid");
                          emailError.classList.remove("visible");
                      }
      
                      if (passwordInput.value.length < 8) {
                          passwordInput.classList.add("invalid");
                          passwordError.classList.add("visible");
                          isValid = false;
                      } else {
                          passwordInput.classList.remove("invalid");
                          passwordError.classList.remove("visible");
                      }
      
      
      
                      if (!isValid) {
                          event.preventDefault();
                      }
                  });
      
                  // Clear validation classes when inputs are focused
                  const inputs = [nameInput, emailInput, passwordInput, confirmPasswordInput];
                  inputs.forEach(input => {
                      input.addEventListener("focus", function () {
                          this.classList.remove("invalid");
                      });
                  });
              });

              //regieter validation
              document.addEventListener("DOMContentLoaded", function() {
                  const form = document.querySelector(".validation-form");
                  const emailInput = document.getElementById("email");
                  const passwordInput = document.getElementById("password");
                  const cpasswordInput = document.getElementById("cpassword");
                  const emailError = document.getElementById("email-error");
                  const passwordError = document.getElementById("password-error");
                  form.addEventListener("submit", function(event) {
                      // event.preventDefault();
                      let isValid = true;
      
      
                      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                      if (!emailRegex.test(emailInput.value)) {
                          emailInput.classList.add("invalid");
                          emailError.classList.add("visible");
                          isValid = false;
                      } else {
                          emailInput.classList.remove("invalid");
                          emailError.classList.remove("visible");
                      }
      
                      if (passwordInput.value.length < 8) {
                          passwordInput.classList.add("invalid");
                          passwordError.classList.add("visible");
                          isValid = false;
                      } else {
                          passwordInput.classList.remove("invalid");
                          passwordError.classList.remove("visible");
                      }
      
                      // if (cpasswordInput.value.length < 8) {
                      //     cpasswordInput.classList.add("invalid");
                      //     cpasswordError.classList.add("visible");
                      //     isValid = false;
                      // } else {
                      //     cpasswordInput.classList.remove("invalid");
                      //     cpasswordError.classList.remove("visible");
                      // }
      
      
      
                      if (!isValid) {
                          event.preventDefault();
                      }
                  });
      
                  // Clear validation classes when inputs are focused
                  const inputs = [nameInput, emailInput, passwordInput, confirmPasswordInput];
                  inputs.forEach(input => {
                      input.addEventListener("focus", function() {
                          this.classList.remove("invalid");
                      });
                  });
              });