<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resume.css">
</head>

<body>
    <div class="full">
        <div class="left">
            <div class="image" style="height: 100px ; width: 139px;">
                <img src="./img_Member/pnhi.jpg" alt="gfg-logo" style="width:100%;height:100%;   object-fit: cover;">
            </div>
            <div class="Contact">
                <h2>Thông tin cá nhân</h2>
                <p><b>Email:</b>hnpnhi@gmail.com</p>
                <p><b>Số điện thoại:</b>0256749392</p>
            </div>
            <div class="Skills">
                <h2>KỸ NĂNG</h2>
                <ul>
                    <li>
                        <p>Ngôn ngữ:
                            C,C++,php,C#</p>
                    </li>
                    <li>
                        <p>Frontend : HTML5, CSS3,
                            JavaScript,react,Boostrap</p>
                    </li>

                </ul>
            </div>
            <div class="Language">
                <h2>NGÔN NGỮ</h2>
                <ul>
                    <li>
                        <p>Tiếng Anh
                        <p>
                    </li>

                </ul>
            </div>
            <div class="Hobbies">
                <h2>SỞ THÍCH</h2>
                <ul>
                    <li>
                        <p>Ngủ</p>
                    </li>
                    <li>
                        <p>Chơi game</P>
                    </li>
                </ul>
            </div>
        </div>
        <div class="right">
            <div class="name">
                <h1>Hồ Ngọc Phương Nhi</h1>
            </div>
            <div class="title">
                <p>Lập trình viên</p>
            </div>
            <div class="Summary">
                <h2>Mục tiêu</h2>
                <p>
                    Ra trường đúng hạn,Có 1 công việc ổn định
                </p>
            </div>
            <div class="Experience">
                <h2>Kinh nghiệm</h2>
                <h3>Thực tập tại công ty sweetSoft</h3>
                <p>Từ ngày 1/12 đến 31/12</p>

            </div>
            <div class="Education">
                <h2>TRÌNH ĐỘ HỌC VẤN</h2>
                <p class="nghieng">Đại Học Sài Gòn (2023 - Hiện tại )<br></p>
                <p class="nghieng">Chuyên nghành công nghệ thông tin<br></p>

            </div>

        </div>
    </div>
</body>

</html>
<style>
    /* Write CSS Here */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        object-fit: cover;
    }

    .full {
        width: 50%;
        max-width: 1000px;
        min-height: 100px;
        background-color: rgb(245, 239, 231);
        margin: 0px;
        display: grid;
        grid-template-columns: 2fr 4fr;
        margin: 0 auto;
        margin-top: 20px;
    }

    .left {
        position: initial;
        background-color: rgb(126, 219, 231);
        padding: 20px;

    }

    .right {
        position: initial;
        background-color: rgb(162, 202, 206);
        padding: 20px;

    }

    li {
        list-style: none;
    }

    .full .image,
    .Contact,
    .Skills,
    .Language,
    .Hobbies,
    .title,
    .Summary,
    .Experience,
    .Education,
    .project {
        margin-bottom: 30px;
    }

    .full h2 {
        background-color: rgb(4, 96, 150);

    }

    .nghieng {
        font-style: italic;
    }

    p {
        font-size: small;
    }
</style>