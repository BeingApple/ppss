<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">기사 등록</h1>
</div>

<form id="dataForm" method="POST" action="/admin/articleWriteProc" enctype="multipart/form-data"> 
    <input type="hidden" id="articleCategory" name="articleCategory" value="<?php echo $articleData->ARTICLE_CATEGORY; ?>"/>
    <?php
        if($articleData->ARTICLE_SEQ > 0){
    ?>
            <input type="hidden" name="articleSeq" value="<?php echo $articleData->ARTICLE_SEQ; ?>" />
            <input type="hidden" name="mode" value="modify" />
    <?php
        }else{
    ?>
            <input type="hidden" name="mode" value="write" />
    <?php
        }
    ?>

    <div class="form-group row">
        <label for="articleTitle" class="col-sm-2 col-form-label" >제목</label>
        <div class="col-sm-10">
            <input type="text" id="articleTitle" name="articleTitle" value="<?php echo $articleData->ARTICLE_TITLE; ?>" class="form-control" placeholder="제목" aria-label="제목">
            <div class="invalid-feedback"></div>
        </div>
    </div>
    
    <fieldset  class="form-group">
        <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">카테고리</legend>
            <div class="col-sm-10">
                <?php
                    if(count($categoryList) > 0){
                        foreach($categoryList as $index => $data){
                ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="category" id="category<?php echo $index+1; ?>" value="<?php echo $data->CATEGORY_NAME; ?>">
                            <label class="form-check-label" for="category<?php echo $index+1; ?>"><?php echo $data->CATEGORY_NAME; ?></label>
                        </div>
                <?php
                        }
                    }
                ?>
                <small id="categoryHelpBlock" style="color:#dc3545; display:none;" class="form-text">카테고리를 선택해주시기 바랍니다.</small>
            </div>
        </div>
    </fieldset>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" >대표 이미지</label>
        <div class="col-sm-10">
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="customFile" id="customFile">
                <label class="custom-file-label" for="customFile">파일을 선택하세요</label>
                <small id="fileHelpBlock" class="form-text text-muted">
                    <?php
                        if($articleData->ARTICLE_FILE_NAME != NULL){
                    ?>
                            <a href="/uploads/ppss/article/<?php echo $articleData->ARTICLE_FILE_NAME; ?>" target="_blank"><?php echo $articleData->ARTICLE_FILE_ORG; ?></a>
                    <?php
                        }else{
                    ?>
                            이미지만 적용 됩니다.
                    <?php
                        }
                    ?>
                </small>
            </div>
        </div>
    </div>

    <div class="form-group row">
    <label for="articleContents" class="col-sm-2 col-form-label" >내용</label>
        <div class="col-sm-10">
            <textarea class="form-control" id="articleContents" name="articleContents" rows="20">
                <?php echo $articleData->ARTICLE_CONTENTS; ?>
            </textarea>
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <fieldset  class="form-group">
        <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">노출 여부</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="viewYn" id="viewYn1" value="Y" <?php echo ($articleData->VIEW_YN == "Y")?"checked":""; ?> >
                    <label class="form-check-label" for="viewYn1">노출</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="viewYn" id="viewYn2" value="N" <?php echo ($articleData->VIEW_YN == "N" || is_null($articleData->VIEW_YN))?"checked":""; ?>>
                    <label class="form-check-label" for="viewYn2">노출 안 함</label>
                </div>
            </div>
        </div>
    </fieldset >
    
    <?php if($articleData->ARTICLE_SEQ > 0){ ?>
        <div class="form-group row">
            <label for="articleTitle" class="col-sm-2 col-form-label" >승인</label>
            <div class="col-sm-10">
                <input type="text" value="<?php echo ($articleData->AUTH_YN == "Y")?"승인":"승인 안 됨"; ?>" class="form-control" disabled>
                <div class="invalid-feedback"></div>
            </div>
        </div>
    <?php } ?>

    <div class="d-flex bd-highlight mb-3">                    
        <?php if($adminData->ADMIN_GRADE == "S"){ ?>
            <div class="btn-group p-2 bd-highlight" role="group">
                <a href="#" class="btn btn-primary" id="authBtn">승인</a>
                <a href="#" class="btn btn-secondary" id="unauthBtn">미승인</a>
            </div>
        <?php } ?>
        <div class="btn-group p-2 bd-highlight" role="group">
            <a href="#" class="btn btn-danger" id="btnDelete">삭제</a>
        </div>
        <div class="btn-group ml-auto p-2 bd-highlight" role="group">
            <button type="button" id="submitBtn" class="btn btn-primary"><?php echo ($articleData->ADMIN_SEQ > 0)?"수정":"등록"; ?></button>
            <button type="button" id="cancelBtn" class="btn btn-primary">목록</button>
        </div>
    </div>
</form>

<form id="imageForm" style="width:0px; height:0; overflow:hidden">
    <input type="file" id="tinyImage" name="tinyImage" />
</form>

<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=pj2hc8mgwdb9lekszj6kezamkceikej1od3m13x0n5l7qz98"></script>
<script>
    $(document).ready(function(){
        tinymce.init({ 
            selector:'#articleContents',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount image'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | image | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ],
            file_browser_callback: function(field_name, url, type, win) {
                if(type=='image') $('#tinyImage').click();
            },
            language_url : '/js/language/ko_KR.js'
        });

        $("#tinyImage").on("change", function(){
            var form = $('#imageForm')[0];
            var data = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "/admin/editorImageUpload",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    eval(data);
                }
            });

            $(this).val("");
        });

        $('#customFile').on('change',function(e){
            var fileName = e.target.files[0].name;
            $(this).next('.custom-file-label').html(fileName);
        });

        $("#articleTitle").on("change", function(){
            $("#articleTitle").removeClass("is-invalid");
        })

        $("input[name=category]").on("change", function(){
            var articleCategory = "";
            $("input[name=category]:checked").each(function(index){
                articleCategory += (index > 0)?",":"";
                articleCategory += $(this).val();
            });

            $("#articleCategory").val(articleCategory);

            if($("input[name=category]:checked").length > 0){
                $("#categoryHelpBlock").hide();
            }
        });

        $("#submitBtn").on("click", function(){
            formSubmit();
        });
        
        $("#cancelBtn").on("click", function(){
            if(confirm("작성한 내용이 유실 됩니다. 목록으로 돌아가시겠습니까?")){
                location.href = "/admin/articleList";
            }
        });

        $("#btnDelete").on("click", function(){
            articleDelete();
        });

        <?php if($adminData->ADMIN_GRADE == "S"){ ?>
            $("#authBtn").on("click", function(){
                articleAuth("Y");
            });

            $("#unauthBtn").on("click", function(){
                articleAuth("N");
            });
        <?php } ?>

        var categoryList = "<?php echo $articleData->ARTICLE_CATEGORY; ?>".split(",");
        for(var i = 0 ; i < categoryList.length ; i++){
            var category = categoryList[i];

            $("input[name=category][value="+category+"]").prop("checked", true);
        }
    });

    function formSubmit(){
        var articleTitle = $("#articleTitle").val();
        var articleCategory = $("#articleCategory").val();

        if(articleTitle == "" || articleTitle == undefined){
            $("#articleTitle").siblings(".invalid-feedback").html("제목을 입력해주시기 바랍니다.");
            $("#articleTitle").removeClass("is-valid");
            $("#articleTitle").addClass("is-invalid");

            return;
        }

        if(articleCategory == "" || articleCategory == undefined){
            $("#categoryHelpBlock").show();

            return;
        }

        $("#dataForm").submit();
    }

    <?php if($adminData->ADMIN_GRADE == "S"){ ?>
        function articleAuth(auth){
            var text = (auth == "Y")? "승인" : "승인 취소";

            if(confirm(text+" 하시겠습니까?")){
                var checkboxValues = [<?php echo $articleData->ARTICLE_SEQ; ?>];
                var allData = { "articleSeqs": checkboxValues, "authYn": auth };

                $.ajax({
                    type: "POST",
                    url: "/admin/articleAuth",
                    data: allData,
                    success: function (data) {
                        if(data == "TRUE"){
                            alert(text+" 되었습니다.");
                        }else{
                            alert("잘못된 접근입니다.");
                        }

                        location.reload();
                    }
                });
            }
        }
    <?php } ?>

    function articleDelete(){
        if(confirm("삭제하시겠습니까?")){
            var checkboxValues = [<?php echo $articleData->ARTICLE_SEQ; ?>];
            var allData = { "articleSeqs": checkboxValues };

            $.ajax({
                type: "POST",
                url: "/admin/articleDelete",
                data: allData,
                success: function (data) {
                    if(data == "TRUE"){
                        alert("삭제 되었습니다.");
                    }else{
                        alert("잘못된 접근입니다.");
                    }

                    location.href = "/admin/articleList";
                }
            });
        }
    }
</script>