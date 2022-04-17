<?php
    include "../connect/connect.php";
    include "../connect/session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원 정보</title>
    <!-- style -->
    <?php
        include "../include/style.php";
    ?>
    <!-- //style -->
</head>
<body>
    <?php
        include "../include/skip.php";
    ?>
    <!-- //skip -->
    
    <?php
        include "../include/header.php";
    ?>
    <!-- //header  -->
    
    <main id="contents">
        <h2 class="ir_so">컨텐츠 영역</h2>
        <section class="join-type center gray">
            <div class="container">
                <h3 class="section__title">퀴즈</h3>
                <p class="section__desc">
                    웹디자이너, 웹 퍼블리셔, 프론트엔드 개발자를 위한 강의 퀴즈입니다.
                </p>
                <div class="quiz__inner">
                    <div class="quiz__header">
                        <div class="quiz__subject">
                            <label for="quizSubject">과목 선택</label>
                            <select name="quizSubject" id="quizSubject">
                                <option value="javascript">javascript</option>
                                <option value="html">html</option>
                                <option value="css">css</option>
                                <option value="php">php</option>
                            </select>
                        </div>
                    </div>
                    <div class="quiz__body">
                        <div class="title">
                            <span class="quiz__num"></span>
                            <span class="quiz__ask"></span>
                            <div class="quiz__desc"></div>
                        </div>
                        <div class="contents">
                            <div class="quiz__selects">
                                <label for="select1">
                                    <input class="select" type="radio" id="select1" name="select" value="1">
                                    <span class="choice"></span>
                                </label>
                                <label for="select2">
                                    <input class="select" type="radio" id="select2" name="select" value="2">
                                    <span class="choice"></span>
                                </label>
                                <label for="select3">
                                    <input class="select" type="radio" id="select3" name="select" value="3">
                                    <span class="choice"></span>
                                </label>
                                <label for="select4">
                                    <input class="select" type="radio" id="select4" name="select" value="4">
                                    <span class="choice"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="quiz__footer">
                        <div class="quiz__btn">
                            <button class="comment green none">해설 보기</button>
                            <button class="confirm ml10 yellow right">정답 확인</button>
                            <button class="next orange right none">다음 문제</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- //main -->
    <?php
        include "../include/footer.php";
    ?>
    <!--//footer -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        let quizAnswer = "";

        function quizView(view){
            $(".quiz__num").text(view.quizID);
            $(".quiz__ask").text(view.quizAsk);
            $(".quiz__desc").text(view.quizDesc);
            $("#select1 + span").text(view.quizChoice1);
            $("#select2 + span").text(view.quizChoice2);
            $("#select3 + span").text(view.quizChoice3);
            $("#select4 + span").text(view.quizChoice4);
            quizAnswer = view.quizAnswer;
        }

        //정답 체크
        function quizCheck(){
            let selectCheck = $(".quiz__selects input:checked").val();
            // 정답 체크 안했으면
            if(selectCheck == null || selectCheck == ''){
                alert("정답을 체크하세요");
            } else {
                $(".quiz__btn .next").slideDown();

                // 정답 체크 했으면 if-> 정답 else -> 오답
                if(selectCheck == quizAnswer){
                    $(".quiz__selects #select"+quizAnswer).addClass("correct");
                } else {
                    $(".quiz__selects #select"+selectCheck).addClass("incorrect");
                    $(".quiz__selects #select"+quizAnswer).addClass("correct");
                }
            }
        }
        
        // 다음 문제 
        function quizNext(){

        }

        function quizData(){
            let quizSubject = $("#quizSubject").val();

            $.ajax({
                url: "quizInfo.php",
                method: "POST",
                data: {"quizSubject": quizSubject},
                dataType: "json",
                success: function(data){
                    console.log(data);
                    quizView(data.quiz);
                },
                error: function(request, status, error){
                    console.log("request" + request);
                    console.log("status" + status);
                    console.log("error" + error);
                }
            });
        }

        quizData();

        //과목선택
        $("#quizSubject").change(function(){
            quizData();
        });

        //정답확인
        $(".quiz__btn .confirm").click(function(){
            // 정답을 클릭했는지, 안했는지 찾음
            quizCheck();
            // $(".quiz__btn .next").fadeIn(); fadeOut / fadeToggle / 
            // $(".quiz__btn .next").slideDown(); slideUp / 
        });

        //다음 문제 버튼
        $(".quiz__btn .next").click(function(){
            quizData();
            $(".quiz__selects input").prop("checked", false);
            $(".quiz__selects input").removeClass("correct");
            $(".quiz__selects input").removeClass("incorrect");
            $(".quiz__btn .next").fadeOut();
        });
    </script>
</body>
</html>