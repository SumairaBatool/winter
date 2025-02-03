<?php 
require_once("../../includes/config.php");  // Correct relative path
include("../../includes/header.php");
?>
<!-- banner -->
<section>
    <div class="breatcome_area d-flex align-items-center">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breatcome_title">
						<div class="breatcome_title_inner pb-2">
							<h2>wellcome on campassess page</h2>
						</div>
						<div class="breatcome_content">
							<ul>
								<li><a href="index.php">Home</a> <i class="fa fa-angle-right"></i> 
                                    <a href="#">admission</a> </li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
    <div class="background-clr ">
        <div class="contact-us ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-7">
                        <div class="contact-width contact-us-text">
                            <h3 class="text margin-padding" style="color: teal; font-size: 40px; margin-bottom: 30px;">Contact Us</h3>
                            <p class="contact-icons" style="color:black;">Lorem ipsum dolor sit amet Lorem ipsum dolor sit Lorem ipsum dolor sit amet consectetur adipisicing
                                elit. Nemo, nobis.</p>
                            <div class="contact-icons">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>Address</span>
                                <h5>Satelite Town Skardu Street -2</h5>
                            </div>
                            <div class="contact-icons">
                                <i class="fa-solid fa-envelope"></i>
                                <span>Mail</span>
                                <h5>shahhmdan@gmail.com</h5>
                            </div>
                            <div class="contact-icons">
                                <i class="fa-solid fa-phone"></i>
                                <span>Phone</span>
                                <h5>+91 0355181879</h5>
                            </div>
                            <div class="contact-icons">
                                <i class="fa-solid fa-globe-pointer"></i>
                                <span>Website</span>
                                <h5>GatewayToIslamicKnowledge</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row col-md-5">
                        <div class="contact-width">
                     <div class="col-md-12">
                        <form action="#" method="post" id="validation-form">
                            <h3 class="text" style="color: teal; margin: 20px 0; font-size: 30px;
                            font-weight: 700;">Get in touch with us</h3>
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" placeholder="name">
                            <div class="error-message" id="name-error">Name is required.</div>
        
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" placeholder="email">
                            <div class="error-message" id="email-error">Please enter a valid email address.</div>
        
                            <label for="subject">Location:</label>
                            <input type="text" id="name" name="subject" placeholder="subject">
                            <div class="error-message" id="name-error">Name is required.</div>
        
                            <label for="message">Message:</label>
                            <textarea id="outline" name="message" rows="10" cols="30" placeholder="messsage"></textarea>
                            <div></div>
                            <input type="submit" value="submit">
                        </form>
                     </div>
                            
                        </div>
                    </div>
                </div>
            </div>
          
          
        </div>
    </div>
    <?php
include("../../includes/footer.php");
?>