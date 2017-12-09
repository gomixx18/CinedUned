<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/jquery-comments.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="css/jquery-comments.css">
        <!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">-->


    </head>
    <body>
        
        <div id="comments-container">TODO write content</div>
        <button id="coment">alert</button>
        <div id="json"></div>
        <script src="js/jquery-2.1.4.js" type="text/javascript"></script>
        <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
        <script type="text/javascript" src="js/jquery-comments.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.textcomplete/1.8.0/jquery.textcomplete.js"></script>
        <script>
				
                                var saveComment = function(data) {

                                        return data;
				}
				$('#comments-container').comments({
					profilePictureURL: 'https://viima-app.s3.amazonaws.com/media/user_profiles/user-icon.png',
					currentUserId: 1,
					roundProfilePictures: true,
					textareaRows: 1,
					enableAttachments: false,
					enableHashtags: false,
					enablePinging: false,
                                        enableEditing: false,
                                        enableUpvoting: false,
                                        enableDeleting: false,
                                        enableDeletingCommentWithReplies: false,
                                        highlightColor: '#AAAAAA',
                                        newestText: 'Recientes',
                                        oldestText: 'Antiguos',
                                        popularText: "",
                                        replyText: "Responder",
                                        youText: "Tú",
					getComments: function(success, error) {
                                           // var tfg = " echo $codigo ?>";
                                            var commentsArray = 
                                            $.ajax({
                                                type: 'get',
                                                url: 'funcionalidad/ComentarioObtener.php',
                                                //dataType: 'json',
                                                data:  {tfg: 'TFG-3-2016-003-1-01'},
                                                success: function(response) {
                                                    console.log(JSON.parse(response));
                                                    success(JSON.parse(response));
                                                }
                                            });
                                        },
                                        postComment: function(data,success,error) {
                                           $.ajax({
                                                type: 'post',
                                                url: 'funcionalidad/ComentarioGuardar.php',
                                                
                                                data:  {json: data},
                                                success: function(response) {
                                                  //var content= JSON.parse(response);
                                                    console.log(response);
                                                    success(saveComment(data));
                                                },
                                                error: error
                                        });
                                    }
                                });
                                $('#coment').click(function(){
                                            $('#json').html(comentario);
                                });
        </script>
    </body>
    
</html>
