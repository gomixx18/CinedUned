var saveComment = function (data) {

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
    getComments: function (success, error) {
        // var tfg = " echo $codigo ?>";
        var commentsArray =
                $.ajax({
                    type: 'get',
                    url: 'funcionalidad/ComentarioObtener.php',
                    //dataType: 'json',
                    data: {tfg: 'TFG-3-2016-003-1-01'},
                    success: function (response) {
                        console.log(JSON.parse(response));
                        success(JSON.parse(response));
                    }
                });
    },
    postComment: function (data, success, error) {
        $.ajax({
            type: 'post',
            url: 'ComentarioGuardar.php',
            //dataType: 'json',
            data: {json: data, },
            success: function (response) {

                console.log(response);
                success(saveComment(data));
            },
            error: error
        });
    }
});