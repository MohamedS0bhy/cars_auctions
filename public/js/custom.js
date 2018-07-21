let host = (location.hostname == 'localhost' || location.hostname == '127.0.0.1') ? 'http://127.0.0.1:8000' : location.hostname ;
let url = host + '/'; //will store base url
let api_url = host + '/api/';//will store api url 
console.log(host);
console.log(api_url);
// will get data from login form and send request to check data
// and return with token if success
// and redirect to proper page based on user role
$("button#loginForm").click(function(){
    console.log('login');
    $('#smallloadingGif').show();
    $('#dangerMessage').hide();
    var email = $('input[name=email]').val();
    var password = $('input[name=password]').val();

    $.ajax({
        type : 'POST',
        url : api_url + 'login',
        data : {
            'email' : email,
            'password' : password
        },
        dataType : 'json'
    }).done(function(data){
        console.log('success');
        if(data.success){
            console.log(data.result.token);
            $.cookie("token", data.result.token, {expires: 1, path: '/'});

            // localStorage.userRole=data.result.user.role;
            // localStorage.userId=data.result.user.id;
            window.location = url + 'login';
        }
        else{
            $('#smallloadingGif').hide();
            $('#dangerMessage').show().text(data.result);
        }
            
    }).fail(function(data){
        console.log('fail');
        console.log(data);
        $('#dangerMessage').show().text(data.statusText);
        $('#smallloadingGif').hide();
    });
    
});

// will get data from register form and send request to check data
// and return with token if success
// and redirect to proper page based on user role
$("button#registerForm").click(function(){
    console.log('register');
    $('#smallloadingGif').show();
    let x = $('form#registerForm').serializeArray().reduce(function(obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});

    console.log(x);

    if(x.password != x.confirmPass)
        $('#dangerMessage').show().text('password doesn\'t match ');
    else{
        $.ajax({
            type : 'POST',
            url : api_url + 'register',
            data : {
                'username' : x.username,
                'email' : x.email,
                'password' : x.password
            },
            dataType : 'json'
        }).done(function(data){
            console.log('success');
            console.log(data);
            if(data.success){

                $('#successMessage').show().text("User registered successfully !");
                
                console.log(data.result.token);
                $.cookie("token", data.result.token, {expires: 1, path: '/'});
                window.location = url + 'login';
            }
            else{
                $('#dangerMessage').show().text(data.message);
                $('#smallloadingGif').hide();
            }
        }).fail(function(data){
            console.log('fail');
            console.log(data);
            $('#dangerMessage').show().text(data.statusText);
            $('#smallloadingGif').hide();
        });
        
    }
});

// logout function will send request with token 
// and make token invalid in return
// and redirect to login page
function logout(){
    console.log('logout');
    $('#logoutGif').show();
    $.ajax({
        type : 'POST',
        url : api_url + 'logout',
        data : {
            'token' : $.cookie('token')
        },
        dataType : 'json'
    }).done(function(data){
        console.log('success');
        if(data.success){
            console.log(data.result);
            $.removeCookie('token', { path: '/' });
            window.location = url + 'login';
        }else{
            alert(data.result);
            $('#logoutGif').hide();
        }
        
    }).fail(function(data){
        console.log('fail');
        console.log(data);
        $('#logoutGif').hide();
    });
}
/**
 $("input[name=file1]").change(function() {
    var names = [];
    for (var i = 0; i < $(this).get(0).files.length; ++i) {
        names.push($(this).get(0).files[i].name);
    }
    $("input[name=file]").val(names);
});
 */
