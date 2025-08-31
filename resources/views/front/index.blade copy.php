<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Fitness Club</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;300;400;500;600;700;800&family=Oswald:wght@200;300;400;500;600;700&family=Poppins:wght@100&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"/>
  <script src="https://kit.fontawesome.com/3b7003e6ac.js" crossorigin="anonymous"></script>
</head>
<body>
	<header>
      <div class="brand"><img src="img/LOGO4.png" alt="brand"></div>
      <div class="menu">
        <div class="btnnn">
          <i class="fas fa-times close-btn" ></i>
        </div>
        <a href="index.html">Home</a>
        <a href="about.html">About</a>
        <a href="Pricing.html">Pricing</a>
        <a href="Contact.html">Contact</a>
        <a href="login-form.html">Login</a>
      </div>
      <div class="btnnn">
        <i class="fas fa-bars menu-btn" style="color:#000"></i>
      </div>
    
        <div class="social">
        <a href="#"><i class="fa fa-facebook-f"></i></a>
        <a href="#"><i class="fa fa-instagram"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        </div>
    </header>
	<section class="home">
      <img class="img-slide active" src="{{ asset('assets/img/front/about-us.jpg') }}" alt="">
      <img class="img-slide" src="{{ asset('assets/img/front/bg.jpg') }}" alt="">
      
      <img class="img-slide" src="{{ asset('assets/img/front/bg3.jpg') }}" alt="">
      <img class="img-slide" src="{{ asset('assets/img/front/bg4.jpg') }}" alt="">
      <img class="img-slide" src="{{ asset('assets/img/front/bg2.jpg') }}" alt="">
      <div class="SlideContent active">
        <h1>Build your body.<br><span>no pain no gain</span></h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <a href="#">Read More</a>
      </div>
      <div class="SlideContent">
        <h1>be strong.<br><span>by Boxing</span></h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <a href="#">Read More</a>
      </div>
      <div class="SlideContent">
        <h1>Let's Do it.<br><span>Together</span></h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <a href="#">Read More</a>
      </div>
      <div class="SlideContent">
        <h1>join us Now.<br><span>not Tomorrow!</span></h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <a href="#">Read More</a>
      </div>
      <div class="SlideContent">
        <h1>Feel Healthy.<br><span>Relax</span></h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <a href="#">Read More</a>
      </div>
      <div class="slider-navigation">
        <div class="nav-btn active"></div>
        <div class="nav-btn"></div>
        <div class="nav-btn"></div>
        <div class="nav-btn"></div>
        <div class="nav-btn"></div>
      </div>
    </section>

    <!--WHY PEOPLE CHOOSE US START--> 
    <section class="dishes">
      <div class="title">
        <h1>WHY PEOPLE CHOOSE US?</h1>
        <p>Our sport experts and latest sports equipment are the winning combination.</p>
      </div>
      <div class="wrapper">
        <div class="card">
          <img src="img/support.jpg" alt="">
          <div class="info">
            <h1>SUPPORT 24/24</h1>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Animi ab voluptate sit aspernatur.</p>
            <a href="#" class="btn">Read More</a>
          </div>
        </div>

        <div class="card">
          <img src="img/Health.jpg" alt="">
          <div class="info">
            <h1>FOCUS ON YOUR HEALTH</h1>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Animi ab voluptate sit aspernatur.</p>
            <a href="#" class="btn">Read More</a>
          </div>
        </div>

        <div class="card">
          <img src="img/Team.png" alt="">
          <div class="info">
            <h1>OUR TRAINERS</h1>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Animi ab voluptate sit aspernatur.</p>
            <a href="#" class="btn">Read More</a>
          </div>
        </div>
      </div>
    </section>
    <!--WHY PEOPLE CHOOSE US END--> 

    <!--Our Classes-->
    <div class="Classes">
      <h1>Our Classes</h1>
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing.</p>
      <div class="cen">
        <div class="Classe">
          <img src="img/boxing-gloves.png" alt="">
          <h2>Boxing Fitness</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>

        <div class="Classe">
          <img src="img/swimming.png" alt="">
          <h2>Swimming</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>

        <div class="Classe">
          <img src="img/yoga.png" alt="">
          <h2>Yoga Programs</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>
        <div class="Classe">
          <img src="img/bodybuilder.png" alt="">
          <h2>Body Building</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>

        <div class="Classe">
          <img src="img/cycling.png" alt="">
          <h2>Cycling</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>

        <div class="Classe">
          <img src="img/dancing.png" alt="">
          <h2>Dancing</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>

      </div>
        <a href="#" class="btn">Read more</a>
    </div>
    <!--end classes-->

    <!--offer-->
    <div class="offer_area offer_bg">
        <div class="container3">
            <div class="row justify-content-end">
                <div class="col-lg-6">
                    <div class="offer_text">
                        <h4>A Big Offer for <br>
                                This Summer</h4>
                        <h3>50% Off</h3>
                        <p>There are many variations of passages of lorem Ipsum available, but the majority have suffered alteration.</p>
                        <a href="#" class="offer-btn">Join Now</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--offer end-->

    <!--PROGRAM START--> 
    <section class="program-section">
        <div class="program-title set-bg" data-setbg="img/red.jpg">
            <div class="containerr">
                <div class="row">
                    <div class="col-lg-7 m-auto text-center">
                        <div class="section-title">
                            <h2>Choose Your Program</h2>
                            <p>Our Crossfit experts can help you discover new training techniques and exercises that offer a dynamic and efficient full-body workout.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="Programs">
            <div class="max-width">
                <div class="contents">
                    <div class="p-card">
                        <div class="box">
                        <i class="fa fa-dumbbell"></i>
                            <h3>Build Body</h3>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus incidunt labore debitis ea repudiandae numquam.</p>
                        </div>
                    </div>
                    <div class="p-card">
                        <div class="box">
                            <i class="fa fa-heart-pulse"></i>
                            <h3>Cardio</h3>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus incidunt labore debitis ea repudiandae numquam.</p>
                        </div>
                    </div>
                    <div class="p-card">
                        <div class="box">
                            <i class="fa fa-bicycle"></i>
                            <h3>Bicycle</h3>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus incidunt labore debitis ea repudiandae numquam.</p>
                        </div>
                    </div>
                    <div class="p-card">
                        <div class="box">
                            <i class="fa fa-person-running"></i>
                            <h3>Running</h3>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus incidunt labore debitis ea repudiandae numquam.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--PROGRAM END--> 

    <!--CLASS TIMETABLE START--> 
     <section class="trainer-schedule class-timetable spad">
        <div class="container5">
            <div class="rowss">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Class Timetable</h2>
                    </div>
                </div>
            </div>
            <div class="rowss">
                <div class="col-lg-12">
                    <div class="schedule-table">
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>
                                    <th>Sunday</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="workout-time">10.00</td>
                                    <td class="gym ts-item" data-tsmeta="gym">
                                        <h6>Gym</h6>
                                        <span>10.00 - 11.00</span>
                                        <div class="trainer-name">
                                            John Smith
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="yoga ts-item" data-tsmeta="yoga">
                                        <h6>Yoga</h6>
                                        <span>10.00 - 12.00</span>
                                        <div class="trainer-name">
                                            Isabelle Wilson
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="body ts-item" data-tsmeta="body">
                                        <h6>Body</h6>
                                        <span>10.00 - 12.00</span>
                                        <div class="trainer-name">
                                            John Smith
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="cardio ts-item" data-tsmeta="cardio">
                                        <h6>Cardio</h6>
                                        <span>10.00 - 11.00</span>
                                        <div class="trainer-name">
                                            Daniel Matthew
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="workout-time">14.00</td>
                                    <td></td>
                                    <td class="running ts-item" data-tsmeta="running">
                                        <h6>Running</h6>
                                        <span>14.00 - 16.00</span>
                                        <div class="trainer-name">
                                            Isabelle Wilson
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="box ts-item" data-tsmeta="box">
                                        <h6>Box</h6>
                                        <span>14.00 - 15.00</span>
                                        <div class="trainer-name">
                                            Kayla Wood
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="gym ts-item" data-tsmeta="gym">
                                        <h6>Gym</h6>
                                        <span>14.00 - 16.00</span>
                                        <div class="trainer-name">
                                            John Smith
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="workout-time">16.00</td>
                                    <td class="cardio ts-item" data-tsmeta="cardio">
                                        <h6>Cardio</h6>
                                        <span>16.00 - 18.00</span>
                                        <div class="trainer-name">
                                            Daniel Matthew
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="gym ts-item" data-tsmeta="gym">
                                        <h6>Gym</h6>
                                        <span>16.00 - 19.00</span>
                                        <div class="trainer-name">
                                            John Smith
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="yoga ts-item" data-tsmeta="yoga">
                                        <h6>Yoga</h6>
                                        <span>16.00 - 18.00</span>
                                        <div class="trainer-name">
                                            Isabelle Wilson
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="gym ts-item" data-tsmeta="gym">
                                        <h6>Gym</h6>
                                        <span>16.00 - 20.00</span>
                                        <div class="trainer-name">
                                            John Smith
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="workout-time">18.00</td>
                                    <td class="box ts-item" data-tsmeta="box">
                                        <h6>Box</h6>
                                        <span>18.00 - 22.00</span>
                                        <div class="trainer-name">
                                            Kayla Wood
                                        </div>
                                    </td>
                                    <td class="body ts-item" data-tsmeta="body">
                                        <h6>Body</h6>
                                        <span>18.00 - 20.00</span>
                                        <div class="trainer-name">
                                            John Smith
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="swimming ts-item" data-tsmeta="swimming">
                                        <h6>swimming</h6>
                                        <span>18.00 - 21.00</span>
                                        <div class="trainer-name">
                                            Daniel Matthew
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="cardio ts-item" data-tsmeta="cardio">
                                        <h6>Cardio</h6>
                                        <span>18.00 - 22.00</span>
                                        <div class="trainer-name">
                                            Daniel Matthew
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="workout-time">20.00</td>
                                    <td></td>
                                    <td class="gym ts-item" data-tsmeta="">
                                        <h6>Gym</h6>
                                        <span>20.00 - 22.00</span>
                                        <div class="trainer-name">
                                            John Smith
                                        </div>
                                    </td>
                                    <td class="body ts-item" data-tsmeta="">
                                        <h6>Body</h6>
                                        <span>20.00 - 21.00</span>
                                        <div class="trainer-name">
                                            John Smith
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="cardio ts-item" data-tsmeta="">
                                        <h6>Cardio</h6>
                                        <span>20.00 - 22.00</span>
                                        <div class="trainer-name">
                                            Daniel Matthew
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="swimming ts-item" data-tsmeta="">
                                        <h6>swimming</h6>
                                        <span>20.00 - 21.00</span>
                                        <div class="trainer-name">
                                            Daniel Matthew
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--CLASS TIMETABLE END-->


    <!--MORE ABOUT US START--> 
    <section class="cta-section" >
        <h2>Start Builing you Body with our Professional Trainers</h2>
        <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <a href="About.html" class="primary-btn">More about us</a>
    </section>
    <!--MORE ABOUT US END-->


    <!--GALLERY START-->
    <section class="gallery">
        <div class="gallery-title">
            <h2>OUR Gallery</h2>
        </div>
        <div class="image-gallery">
            <div class="image-box">
                <img src="img/3.png" alt="img.jpg" />
                <div class="overlay">
                <div class="details">
                    <h3 class="title">
                    <a href="#">Builing Body</a>
                    </h3>
                    <span class="category">
                    <a href="#">click for more detaills</a>
                    </span>
                </div>
                </div>
            </div>
            <div class="image-box">
                <img src="img/gallery-3.jpg" alt="img.jpg" />
                <div class="overlay">
                <div class="details">
                    <h3 class="title">
                    <a href="#">cardio</a>
                    </h3>
                    <span class="category">
                    <a href="#">click for more detaills</a>
                    </span>
                </div>
                </div>
            </div>
            <div class="image-box">
                <img src="img/gallery-6.jpg" alt="img.jpg" />
                <div class="overlay">
                <div class="details">
                    <h3 class="title">
                    <a href="#">Team</a>
                    </h3>
                    <span class="category">
                    <a href="#">click for more detaills</a>
                    </span>
                </div>
                </div>
            </div>
            <div class="image-box">
                <img src="img/Running.jpg" alt="img.jpg" />
                <div class="overlay">
                <div class="details">
                    <h3 class="title">
                    <a href="#">Running</a>
                    </h3>
                    <span class="category">
                    <a href="#">click for more detaills</a>
                    </span>
                </div>
                </div>
            </div>
            <div class="image-box">
                <img src="img/swimming.jpg" alt="img.jpg" />
                <div class="overlay">
                <div class="details">
                    <h3 class="title">
                    <a href="#">Swimming</a>
                    </h3>
                    <span class="category">
                    <a href="#">click for more detaills</a>
                    </span>
                </div>
                </div>
            </div>
            <div class="image-box">
                <img src="img/workout.jpg" alt="img.jpg" />
                <div class="overlay">
                <div class="details">
                    <h3 class="title">
                    <a href="#">Workout</a>
                    </h3>
                    <span class="category">
                    <a href="#">click for more detaills</a>
                    </span>
                </div>
                </div>
            </div>
            <div class="image-box">
                <img src="img/yoga.jpg" alt="img.jpg" />
                <div class="overlay">
                <div class="details">
                    <h3 class="title">
                    <a href="#">Yoga</a>
                    </h3>
                    <span class="category">
                    <a href="#">click for more detaills</a>
                    </span>
                </div>
                </div>
            </div>
            <div class="image-box">
                <img src="img/Boxing.jpg" alt="img.jpg" />
                <div class="overlay">
                <div class="details">
                    <h3 class="title">
                    <a href="#">Boxing</a>
                    </h3>
                    <span class="category">
                    <a href="#">click for more detaills</a>
                    </span>
                </div>
                </div>
            </div>
            <div class="image-box">
                <img src="img/cycling.jpg" alt="img.jpg" />
                <div class="overlay">
                <div class="details">
                    <h3 class="title">
                    <a href="#">Cycling</a>
                    </h3>
                    <span class="category">
                    <a href="#">click for more detaills</a>
                    </span>
                </div>
                </div>
            </div>
        </div>
    </section>
    <!--GALLERY END-->

    <!--FOOTER START-->  
    <footer>
        <div class="main-content">
            <div class="left box">
            <h2>About us</h2>
            <div class="content">
                <p>Lorem, ipsum, dolor sit amet consectetur adipisicing elit. Optio dolore id repudiandae accusamus qui! Nostrum, ex quasi modi consectetur quis numquam, corporis sit obcaecati dolor magnam perferendis asperiores similique cum.</p>
                <div class="footsocial">
                <a href="#"><span class="fa fa-facebook-f"></span></a>
                <a href="#"><span class="fa fa-twitter"></span></a>
                <a href="#"><span class="fa fa-instagram"></span></a>
                <a href="#"><span class="fa fa-youtube"></span></a>
                </div>
            </div>
            </div>
            <div class="center box">
            <h2>Address</h2>
            <div class="Footercontent">
                <div class="place">
                <span class="fas fa-map-marker-alt"></span>
                <span class="text">Morocco, Rabat</span>
                </div>
                <div class="phone">
                <span class="fas fa-phone-alt"></span>
                <span class="text">+212 06xxxxxx</span>
                </div>
                <div class="email">
                <span class="fas fa-envelope"></span>
                <span class="text">abc@example.com</span>
                </div>
            </div>
            </div>
            <div class="right box">
            <h2>Contact us</h2>
            <div class="Footercontent">
                <form action="#">
                <div class="email">
                    <div class="text">Email *</div>
                    <input type="email" required>
                </div>
                <div class="msg">
                    <div class="text">Message *</div>
                    <textarea rows="2" cols="25" required></textarea>
                </div>
                <div class="buttonn">
                    <button type="submit">Send</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        <div class="bottom">
            <center>
            <span class="credit">Created By <a href="#">Soukaina Sbai</a> | </span>
            <span class="far fa-copyright"></span><span> 2022 All rights reserved.</span>
            </center>
        </div>
    </footer>
    <!--FOOTER END-->


    <script type="text/javascript">

        //----------------------------------------------------------
        //Javacript for img slider navigation
        const btns = document.querySelectorAll(".nav-btn");
        const slides = document.querySelectorAll(".img-slide");
        const contents = document.querySelectorAll(".SlideContent");

        var sliderNav = function(manual){
        btns.forEach((btn) => {
            btn.classList.remove("active");
        });

        slides.forEach((slide) => {
            slide.classList.remove("active");
        });

        contents.forEach((content) => {
            content.classList.remove("active");
        });

        btns[manual].classList.add("active");
        slides[manual].classList.add("active");
        contents[manual].classList.add("active");
        }

        btns.forEach((btn, i) => {
        btn.addEventListener("click", () => {
            sliderNav(i);   
        });
        });

        //---------------------------------------------------
        //img slider autoplay
        var playSlider;
        var slideNumber = 0;
        var numberOfSlides = 5;

        var repeater = function(){

        playSlider = setInterval(function(){

            btns.forEach((btn) => {
            btn.classList.remove("active");
            });

            slides.forEach((slide) => {
            slide.classList.remove("active");
            });

            contents.forEach((content) => {
            content.classList.remove("active");
            });

            slideNumber++;

            if (slideNumber > (numberOfSlides - 1)){
            slideNumber = 0;
            }

            btns[slideNumber].classList.add("active");
            slides[slideNumber].classList.add("active");
            contents[slideNumber].classList.add("active");
            },5000);
        }

        repeater();
        //-------------------------------------------------------------

        //javascript for navigation bar effect on scroll
        window.addEventListener("scroll", function(){
        var header = document.querySelector("header");
        header.classList.toggle('sticky', window.scrollY > 0);
        });


        //-------------------------------------------------------------
        //javascript for responsive navigation sidebar menu
        var menu = document.querySelector('.menu');
        var menuBtn = document.querySelector('.menu-btn');
        var closeBtn = document.querySelector('.close-btn');

        menuBtn.addEventListener("click", () => {
        menu.classList.add('active');
        });

        closeBtn.addEventListener("click", () => {
        menu.classList.remove('active');
        });
    </script>
</body>
</html>