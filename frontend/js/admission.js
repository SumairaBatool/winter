// <!-- login form javascript-->
// <!-- login form slefstyle-->
// let popup=document.getElementById("popup");
// function openpopup(){
//    popup.classList.add("openpopup");
// }

// login crosse icon handle
// $(document).ready(function(){
// $('#hideform').click(function(){
//     $("#popup").hide();
// })
// })
 // <!-- form validation -->
//  $(document).ready(function () {
//     $("#form-validate").submit(function () {
//         // User fullname validation
//         let userName = $("#fulname").val();
//         let namepattren = /^[A-Za-z ]+$/;

//         if (userName === "") {
//             $(".show-fulname-error").html("**Name is required").addClass("name-error");
//             return false;
//         } else if (!namepattren.test(userName)) {
//             $(".show-fulname-error").html("Name should be contain only charecter").addClass("name-error");
//             return false;
//         } else {
//             $(".show-fulname-error").hide();
//             $("#fulname").addClass("validation-success-name");
//         }

        // Password validation
//         let userpass = $("#password").val();
//         let passpattren= /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;

//         if (userpass == "") {
//             $(".show-password-error").html("**Password is required").addClass("password-error");
//             return false;
//         } 
//          else if (!passpattren.test(userpass)) {
//             $(".show-password-error").html("Password not matched!").addClass("password-error");
//             return false;
//         } 
//         else {
//             $(".show-password-error").hide();
//             $("#password").addClass("validation-success-pass");
//         }
//         // All validations passed, continue with form submission
//         return true;
//     });
// });

// form validation java
// $(document).ready(function () {
//     $("#myForm").validate({
//         rules: {
//             username: {
//                 required: true,
//                 minlength: 3,
//             },
//             email: {
//                 required: true,
//                 email: true
//             },
//             password: {
//                 required: true,
//                 minlength: 6
//             },
//             cellno: {
//                 required: true,
//                 minlength: 11
//             },
//             cnic: {
//                 required: true,
//                 minlength: 13
//             }
//         },
//         messages: {
//             username: {
//                 required: "Please enter your username",
//                 minlength: "Username must be at least 3 characters",
//             },
//             email: {
//                 required: "Please enter your email",
//                 email: "Please enter a valid email address"
//             },
//             password: {
//                 required: "Please enter your password",
//                 minlength: "Password must be at least 6 characters long"
//             },
//             cellno: {
//                 required: "Please enter your phone number",
//                 minlength: "Password must be at least 11 characters long"
//             },
//             cnic: {
//                 required: "Please enter your CNIC number",
//                 minlength: "Password must be at least 13 characters long"
//             },
//         },
//         errorPlacement: function (error, element) {
//             error.insertAfter(element);
//         },
//         highlight: function (element, errorClass, validClass) {
//             $(element).addClass(errorClass).removeClass(validClass);
//         },
//         unhighlight: function (element, errorClass, validClass) {
//             $(element).removeClass(errorClass).addClass(validClass);
//         },
//         submitHandler: function (form) {
            
//             return false;
//         }
//     });
// });
// jquery ui java some code here
//acccordion...................
$( "#accordion" ).accordion();

var availableTags = [
	"ActionScript",
	"AppleScript",
	"Asp",
	"BASIC",
	"C",
	"C++",
	"Clojure",
	"COBOL",
	"ColdFusion",
	"Erlang",
	"Fortran",
	"Groovy",
	"Haskell",
	"Java",
	"JavaScript",
	"Lisp",
	"Perl",
	"PHP",
	"Python",
	"Ruby",
	"Scala",
	"Scheme"
];
$( "#autocomplete" ).autocomplete({
	source: availableTags
});

$( "#button" ).button();
$( "#button-icon" ).button({
	icon: "ui-icon-gear",
	showLabel: false
});

$( "#radioset" ).buttonset();

$( "#controlgroup" ).controlgroup();

$( "#tabs" ).tabs();

$( "#dialog" ).dialog({
	autoOpen: false,
	width: 400,
	buttons: [
		{
			text: "Ok",
			click: function() {
				$( this ).dialog( "close" );
			}
		},
		{
			text: "Cancel",
			click: function() {
				$( this ).dialog( "close" );
			}
		}
	]
});

// Link to open the dialog
$( "#dialog-link" ).click(function( event ) {
	$( "#dialog" ).dialog( "open" );
	event.preventDefault();
});

$( "#datepicker" ).datepicker({
	inline: true
});

$( "#slider" ).slider({
	range: true,
	values: [ 17, 67 ]
});

$( "#progressbar" ).progressbar({
	value: 20
});

$( "#spinner" ).spinner();

$( "#menu" ).menu();

$( "#tooltip" ).tooltip();

$( "#selectmenu" ).selectmenu();

// Hover states on the static widgets
$( "#dialog-link, #icons li" ).hover(
	function() {
		$( this ).addClass( "ui-state-hover" );
	},
	function() {
		$( this ).removeClass( "ui-state-hover" );
	}
);

  