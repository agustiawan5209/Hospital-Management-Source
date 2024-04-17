<?php
session_start();
include("includes/config.php");
// $conn = mysqli_connect('localhost','root','','contact_db') or die('connection failed');
include('includes/connection.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>complete responsive hospital website create by win coder</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="<?= BASE_URL . 'assets/css/app.css' ?>">

</head>

<body>

    <!-- header section starts  -->

    <header class="header">

        <a href="#" class="logo text-white"> <img src="assets/img/logo-dark.png" alt="" width="30"> KLINIK <strong>MB</strong> </a>

        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#about">about</a>
            <a href="#services">services</a>
            <a href="#appointment">appointment</a>
            <a href="#review">review</a>
            <a href="#blogs">blogs</a>
            <?php
            if (!isset($_SESSION['auth'])) {
            ?>
                <a href="login.php">
                    <button type="button" class="btn text-dark">Login</button>
                </a>
            <?php
            } else {
            ?>
                <a href="login.php">
                    <button type="button" class="btn text-dark"><?= $_SESSION['auth']['first_name'] . ' ' . $_SESSION['auth']['last_name'] ?></button>
                </a>
            <?php } ?>
        </nav>

        <div id="menu-btn" class="fas fa-bars"></div>

    </header>

    <!-- header section ends -->

    <!-- home section starts  -->

    <section class="home" id="home">

        <div class="image">
            <img src="<?= BASE_URL . 'assets/image/gut-health-animate.svg' ?>" alt="">
        </div>

        <div class="content">
            <h3>we take care of your healthy life</h3>
            <p> A person who has good physical health is likely to have bodily functions and processes working at their peak.</p>
            <a href="#appointment" class="btn"> appointment us <span class="fas fa-chevron-right"></span> </a>
        </div>

    </section>

    <!-- home section ends -->

    <!-- icons section starts  -->

    <section class="icons-container">

        <div class="icons">
            <i class="fas fa-user-md"></i>
            <h3>150+</h3>
            <p>doctors at work</p>
        </div>

        <div class="icons">
            <i class="fas fa-users"></i>
            <h3>1030+</h3>
            <p>satisfied patients</p>
        </div>

        <div class="icons">
            <i class="fas fa-procedures"></i>
            <h3>490+</h3>
            <p>bed facility</p>
        </div>

        <div class="icons">
            <i class="fas fa-hospital"></i>
            <h3>70+</h3>
            <p>available hospitals</p>
        </div>

    </section>

    <!-- icons section ends -->

    <!-- about section starts  -->

    <section class="about" id="about">

        <h1 class="heading"> <span>about</span> us </h1>

        <div class="row">

            <div class="image">
                <img src="<?= BASE_URL . 'assets/image/team-doctor.svg' ?>" alt="">
            </div>

            <div class="content">
                <h3>take the world's best quality treatment</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure ducimus, quod ex cupiditate ullam in assumenda maiores et culpa odit tempora ipsam qui, quisquam quis facere iste fuga, minus nesciunt.</p>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Natus vero ipsam laborum porro voluptates voluptatibus a nihil temporibus deserunt vel?</p>
                <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
            </div>

        </div>

    </section>

    <!-- about section ends -->

    <!-- services section starts  -->

    <section class="services" id="services">

        <h1 class="heading"> our <span>services</span> </h1>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-notes-medical"></i>
                <h3>free checkups</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad, omnis.</p>
                <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
            </div>

            <div class="box">
                <i class="fas fa-ambulance"></i>
                <h3>24/7 ambulance</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad, omnis.</p>
                <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
            </div>

            <div class="box">
                <i class="fas fa-user-md"></i>
                <h3>expert doctors</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad, omnis.</p>
                <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
            </div>

            <div class="box">
                <i class="fas fa-pills"></i>
                <h3>medicines</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad, omnis.</p>
                <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
            </div>

            <div class="box">
                <i class="fas fa-procedures"></i>
                <h3>bed facility</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad, omnis.</p>
                <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
            </div>

            <div class="box">
                <i class="fas fa-heartbeat"></i>
                <h3>total care</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad, omnis.</p>
                <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
            </div>

        </div>

    </section>

    <!-- services section ends -->



    <!-- appointmenting section starts   -->

    <section class="appointment" id="appointment">

        <h1 class="heading"> <span>appointment</span> now </h1>

        <div class="row">

            <div class="image">
                <img src="<?= BASE_URL . 'assets/image/appointment-icon.svg' ?>" alt="">
            </div>

            <form action="includes/session_login.php" method="post">
                <?php
                $patient_name = '';
                $patient_number = '';
                if (isset($_SESSION['auth'])) {
                    $patient_name = $_SESSION['auth']['first_name'] . ' ' . $_SESSION['auth']['last_name'];
                    $patient_number = $_SESSION['auth']['phone'];
                }
                if (isset($message)) {
                    foreach ($message as $message) {
                        echo '<p class ="message">' . $message . '</p>';
                    }
                }
                ?>

                <h3>make appointment</h3>
                <input type="text" name="name" placeholder="patient name" class="box" value="<?= $patient_name ?>">
                <input type="number" name="number" placeholder="patient number" class="box" value="<?= $patient_number ?>">
                <select name="department_doctor" id="department_doctor" class="box">
                    <option value="">--Select Doctor Department--</option>
                    <?php
                    $department_app = mysqli_query($connection, "SELECT *
                    FROM tbl_employee AS employee
                    WHERE role = '2';");
                    while ($row = mysqli_fetch_array($department_app)) {
                        // Check If The Doctor Has Price
                        $price_tbl = mysqli_query($connection, "SELECT * FROM tbl_price WHERE doctor_id='" . $row['id']. "'");
                        
                        if (mysqli_num_rows($price_tbl) > 0) {
                    ?>
                            <option value="<?= $row['id'] ?>"><?= $row['first_name'] . " " . $row['last_name'] . " - " . $row['department_name'] ?></option>

                    <?php }
                    } ?>
                </select>

                <div class="form-box">
                    <label for="dob" class="label">patient dirth of birthday</label>
                    <input type="date" name="dob" placeholder="patient dirth of birthday" class="box">

                </div>
                <div class="form-box">
                    <label for="date" class="label">Appointment date</label>

                    <input type="date" name="date" placeholder="appointment date" class="box">
                </div>
                <div class="form-box">
                    <label for="time" class="label">Appointment Time</label>
                    <input type="time" id="time" name="time" class="box" placeholder="appointment time">
                </div>




                <input type="text" name="message" class="box" placeholder="send message to doctor">
                <input type="submit" name="submit-appointment" value="appointment now" class="btn">
            </form>

        </div>


    </section>

    <!-- appointmenting section ends -->


    <!-- doctors section starts  -->

    <section class="doctors" id="doctors">

        <h1 class="heading"> our <span>doctors</span> </h1>

        <div class="box-container">
            <?php
            $fetch_query = mysqli_query($connection, "SELECT id, first_name, last_name, username, emailid, dob, gender, address, bio, phone,department_name FROM tbl_employee  WHERE role = '2';");
            while ($row = mysqli_fetch_array($fetch_query)) {
            ?>
                <div class="box">
                    <img src="image/doc-1.jpg" alt="">
                    <h3><?= $row['first_name'] . ' ' . $row['last_name'] ?></h3>
                    <span><?= $row['department_name'] ?></span>

                    <!-- Schedule Doctor -->
                    <?php
                    $schedule = mysqli_query($connection, "SELECT * FROM tbl_schedule WHERE doctor_id = " . $row['id']);
                    $data_schedule = mysqli_fetch_assoc($schedule);
                    if (mysqli_num_rows($schedule) > 0) {
                    ?>
                        <div class="content">
                            <div class="icon">
                                <span href="#"> Available Days : <i class="fas fa-calendar"></i> <?= $data_schedule['available_days'] ?> </span>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="content">
                            <div class="icon">
                                <span href="#"> Available Days : <i class="fas fa-calendar"></i> not yet available </span>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            <?php } ?>
        </div>

    </section>

    <!-- doctors section ends -->

    <!-- review section starts  -->

    <section class="review" id="review">

        <h1 class="heading"> client's <span>review</span> </h1>

        <div class="box-container">

            <div class="box">
                <img src="<?= BASE_URL . 'assets/image/pic-1.jpg' ?>" alt="">
                <h3>win coder</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam sapiente nihil aperiam? Repellat sequi nisi aliquid perspiciatis libero nobis rem numquam nesciunt alias sapiente minus voluptatem, reiciendis consequuntur optio dolorem!</p>
            </div>

            <div class="box">
                <img src="<?= BASE_URL . 'assets/image/pic-1.jpg' ?>" alt="">
                <h3>win coder</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam sapiente nihil aperiam? Repellat sequi nisi aliquid perspiciatis libero nobis rem numquam nesciunt alias sapiente minus voluptatem, reiciendis consequuntur optio dolorem!</p>
            </div>

            <div class="box">
                <img src="<?= BASE_URL . 'assets/image/pic-1.jpg' ?>" alt="">
                <h3>win coder</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam sapiente nihil aperiam? Repellat sequi nisi aliquid perspiciatis libero nobis rem numquam nesciunt alias sapiente minus voluptatem, reiciendis consequuntur optio dolorem!</p>
            </div>

        </div>

    </section>

    <!-- review section ends -->

    <!-- blogs section starts  -->

    <section class="blogs" id="blogs">

        <h1 class="heading"> our <span>blogs</span> </h1>

        <div class="box-container">

            <div class="box">
                <div class="image">
                    <img src="<?= BASE_URL . 'assets/image/blog-1.jpg' ?>" alt="">
                </div>
                <div class="content">
                    <div class="icon">
                        <a href="#"> <i class="fas fa-calendar"></i> 21 november, 2022 </a>
                        <a href="#"> <i class="fas fa-user"></i> by win coder </a>
                    </div>
                    <h3>blog title win coder goes here</h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Provident, eius.</p>
                    <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="<?= BASE_URL . 'assets/image/blog-2.jpg' ?>" alt="">
                </div>
                <div class="content">
                    <div class="icon">
                        <a href="#"> <i class="fas fa-calendar"></i> 21 november, 2022 </a>
                        <a href="#"> <i class="fas fa-user"></i> by win coder </a>
                    </div>
                    <h3>blog title win coder goes here</h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Provident, eius.</p>
                    <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="<?= BASE_URL . 'assets/image/blog-3.jpg' ?>" alt="">
                </div>
                <div class="content">
                    <div class="icon">
                        <a href="#"> <i class="fas fa-calendar"></i> 21 november, 2022 </a>
                        <a href="#"> <i class="fas fa-user"></i> by win coder </a>
                    </div>
                    <h3>blog title win coder goes here</h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Provident, eius.</p>
                    <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
                </div>
            </div>
            <div class="box">
                <div class="image">
                    <img src="<?= BASE_URL . 'assets/image/blog-4.jpg' ?>" alt="">
                </div>
                <div class="content">
                    <div class="icon">
                        <a href="#"> <i class="fas fa-calendar"></i> 21 november, 2022 </a>
                        <a href="#"> <i class="fas fa-user"></i> by win coder </a>
                    </div>
                    <h3>blog title win coder goes here</h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Provident, eius.</p>
                    <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
                </div>
            </div>
            <div class="box">
                <div class="image">
                    <img src="<?= BASE_URL . 'assets/image/blog-5.jpg' ?>" alt="">
                </div>
                <div class="content">
                    <div class="icon">
                        <a href="#"> <i class="fas fa-calendar"></i> 21 november, 2022 </a>
                        <a href="#"> <i class="fas fa-user"></i> by win coder </a>
                    </div>
                    <h3>blog title win coder goes here</h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Provident, eius.</p>
                    <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
                </div>
            </div>
            <div class="box">
                <div class="image">
                    <img src="<?= BASE_URL . 'assets/image/blog-6.jpg' ?>" alt="">
                </div>
                <div class="content">
                    <div class="icon">
                        <a href="#"> <i class="fas fa-calendar"></i> 21 november, 2022 </a>
                        <a href="#"> <i class="fas fa-user"></i> by win coder </a>
                    </div>
                    <h3>blog title win coder goes here</h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Provident, eius.</p>
                    <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
                </div>
            </div>

        </div>

    </section>

    <!-- blogs section ends -->

    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>quick links</h3>
                <a href="#home"> <i class="fas fa-chevron-right"></i> home </a>
                <a href="#about"> <i class="fas fa-chevron-right"></i> about </a>
                <a href="#services"> <i class="fas fa-chevron-right"></i> services </a>
                <a href="#doctors"> <i class="fas fa-chevron-right"></i> doctors </a>
                <a href="#appointment"> <i class="fas fa-chevron-right"></i> appointment </a>
                <a href="#review"> <i class="fas fa-chevron-right"></i> review </a>
                <a href="#blogs"> <i class="fas fa-chevron-right"></i> blogs </a>
            </div>

            <div class="box">
                <h3>our services</h3>
                <a href="#"> <i class="fas fa-chevron-right"></i> dental care </a>
                <a href="#"> <i class="fas fa-chevron-right"></i> message therapy </a>
                <a href="#"> <i class="fas fa-chevron-right"></i> cardioloty </a>
                <a href="#"> <i class="fas fa-chevron-right"></i> diagnosis </a>
                <a href="#"> <i class="fas fa-chevron-right"></i> ambulance service </a>
            </div>

            <div class="box">
                <h3>appointment info</h3>
                <a href="#"> <i class="fas fa-phone"></i> +8801688238801 </a>
                <a href="#"> <i class="fas fa-phone"></i> +8801782546978 </a>
                <a href="#"> <i class="fas fa-envelope"></i> wincoder9@gmail.com </a>
                <a href="#"> <i class="fas fa-envelope"></i> sujoncse26@gmail.com </a>
                <a href="#"> <i class="fas fa-map-marker-alt"></i> sylhet, bangladesh </a>
            </div>

            <div class="box">
                <h3>follow us</h3>
                <a href="#"> <i class="fab fa-faceappointment-f"></i> faceappointment </a>
                <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
                <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
                <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
                <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
                <a href="#"> <i class="fab fa-pinterest"></i> pinterest </a>
            </div>

        </div>

        <div class="credit"> created by <span>win coder</span> | all rights reserved </div>

    </section>

    <!-- footer section ends -->


    <!-- js file link  -->
    <script src="js/script.js"></script>

</body>

</html>