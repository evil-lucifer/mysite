/* 
    Авторизация
*/

$('.login-btn').click(function (e) {
    e.preventDefault();

    $(`input`).removeClass('error');

    let login = $('input[name = "login"]').val(),
        password = $('input[name = "password"]').val();

    $.ajax({
        url: 'core/signin.php',
        type: 'POST',
        dataType: 'json',
        data: {
            login: login,
            password: password
        },
        success: function (data) {

            if (data.status) {
                window.event.returnValue = false;
                document.location.href = "/profile.php";

            } else {
                $('.msg').removeClass('none').text(data.message);
            }
        }
    });

});

/*
    Получение аватарки с поля
 */

let avatar = false;

$('input[name = "avatar"]').change(function (e) {
    avatar = e.target.files[0];
});    

/*
    Регистрация
 */

$('.register-btn').click(function (e) {
    e.preventDefault();
    
    $(`input`).removeClass('error');
    
    let login = $('input[name = "login"]').val(),
        password = $('input[name = "password"]').val(),
        name = $('input[name = "name"]').val(),
        email = $('input[name = "email"]').val(),
        password_confirm = $('input[name = "password_confirm"]').val();
    
    $.ajax({
        url: 'core/signup.php',
        type: 'POST',
        dataType: 'json',
        data: {
            login: login,
            password: password,
            name: name,
            email: email,
            password_confirm: password_confirm
        },
        success: function (data) {
    
            if (data.status) {
                window.event.returnValue = false;
                document.location.href = '/index.php';
                
            } else if (data.type === 1) {
                data.fields.forEach(function (field) {
                    $(`input[name = "${field}"]`).addClass('error');
                });
    
            }
            $('.msg').removeClass('none').text(data.message);
       }
    });
 });

 /*
    Аватар в профиле
 */
 $('.saveimg').click(function(e){
    e.preventDefault();
       
    let id = $('input[name = "id"]').val();

    let formData = new FormData();
    formData.append('id', id);
    formData.append('avatar', avatar);

    $.ajax({
        url: 'core/img.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success: function (data) {
            if (data.status) {
                window.event.returnValue = false;
                document.location.href = '/profile.php';
            } else {
                $('.msg').removeClass('none').text(data.message);
            }
        }

    });
 });

/*
    Редактирование данных профиля
*/
$('.update-btn').click(function (e) {
    e.preventDefault();
    
    $(`input`).removeClass('error');
    
    let id = $('input[name = "id"]').val(),
        login = $('input[name = "login"]').val(),
        oldpass = $('input[name = "oldpass"]').val(),
        newpass = $('input[name = "newpass"]').val(),
        newpass_confirm = $('input[name = "newpass_confirm"]').val(),
        name = $('input[name = "name"]').val(),
        email = $('input[name = "email"]').val();
    
    let formData = new FormData();
    formData.append('id', id);
    formData.append('avatar', avatar);
    formData.append('login', login);
    formData.append('oldpass', oldpass);
    formData.append('newpass', newpass);
    formData.append('newpass_confirm', newpass_confirm);
    formData.append('name', name);
    formData.append('email', email);

    $.ajax({
        url: 'core/update.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success: function (data) {

            if (data.status) {
                window.event.returnValue = false;
                document.location.href = '/profile.php';
                
            } else if (data.type === 1) {
                data.fields.forEach(function (field) {
                    $(`input[name = "${field}"]`).addClass('error');
                });
            }
            $('.msg').removeClass('none').text(data.message);
       }
    });
 });

/*
    Неподтвержденный профиль
*/
$('.verif-btn').click( function(e) {
    e.preventDefault();

    let email =  $('input[name = "email"]').val(),
        hash = $('input[name = "hash"]').val();

    $.ajax({
        url: 'core/send.php',
        type: 'POST',
        dataType: 'json',
        data: {
            email: email,
            hash: hash,
        },
        success: function (data) {
            $('.msg').removeClass('none').text(data.message);
           }
    });    
});

/*
    Удаление пользователей
*/
$('.delUser').click(function() {
    let id = $(this).attr('data-id'),
        that = this;

    document.querySelector('.modal').classList.add('active');
    
    $('#yes').click(function() {
        $.ajax({
            url:"core/deluser.php",
            type: 'POST',
            dataType:'json',
            data: {
                id: id,
            },
            success: function (data){
                if (data.status) {
                    $(that).closest('tr').remove();
                }
                else{
                    $('.msg').removeClass('none').text(data.message);
                }
                document.querySelector('.modal').classList.remove('active');
            }

        });
    });

    $('#no').click(function() {
        document.querySelector('.modal').classList.remove('active');
    });
});

/*
    Совещания
*/

/*
    Добавление совещаний
*/

$('#add').click(function() {
    document.querySelector('#modaladd').classList.add('active');
    
    $('.yes').click(function(e){
        e.preventDefault();
        let name = $('input[name = "name"]').val(),
            date = $('input[name = "date"]').val(),
            time = $('input[name = "time"]').val();

        $.ajax({
            url: "core/addmeet.php",
            type: "POST",
            dataType: "json",
            data: {
                name: name,
                date: date,
                time: time
            },
            success: function(data) {
                if (data.status){
                    // date = new Date(date);
                    // let days = ['Воскресенье','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота'],
                    //     months = ['янв','фев','мар','апр','май','июн','июл','авг','сен','окт','ноя','дек'],
                    //     m = date.getMonth(),
                    //     nd = date.getDay(),
                    //     d = date.getDate(),
                    //     n = date.getDay(),
                    //     html = "<td>" + days[nd] + "</td><td>" +name +"</td><td>" + d + " " + months[m] + "</td><td>" + time + "</td><td style = 'display: none'>" + newdate + "</td>";

                    //     html += "<td class='button'><button type='button' class = 'upd' value = '"+ +"' data-id = '" + data.message + "'>Редактировать</button></td><td class='button'><button type='button' class='delete' value = '" + + "' data-id = '" + data.message + "'>Удалить</button></td>";
                    
                    // $('#meets tr:last').after(html);
                    //document.querySelector('#modaladd').classList.remove('active');
                    window.event.returnValue = false;
                    document.location.href = "/meetstr.php";
                }else{
                    if (data.type === 1) {
                        data.fields.forEach(function (field) {
                            $(`input[name = "${field}"]`).addClass('error');
                    });
                    $('.msg').removeClass('none').text(data.message);
                    }
                }
            }
        });   
    });

    $('.no').click(function() {
        document.querySelector('#modaladd').classList.remove('active');
    });
});

/*
    Редактирование совещаний
*/

$('.upd').click(function(){
     
    let i = $(this).val(),
        id = $(this).attr('data-id'),
        table = document.getElementById(i).getElementsByTagName("td"),
        n =  table[1].innerText,
        t = table[3].innerText,
        d = table[4].innerText,
        that = this;

    $('input[name = "namemeet"]').val(n);
    $('input[name = "datemeet"]').val(d);
    $('input[name = "timemeet"]').val(t);
   
    document.querySelector('#modalupd').classList.add('active');
     
    $('.yes').click(function(e){
        e.preventDefault();
        
        let name = $('input[name = "namemeet"]').val(),
            newdate = $('input[name = "datemeet"]').val(),
            time = $('input[name = "timemeet"]').val();

        $.ajax({
            url: "core/updmeet.php",
            type: "POST",
            dataType: "json",
            data: {
                name: name,
                date: newdate,
                time: time
            },
            success: function(data) {
                if (data.status){
                    newdate = new Date(newdate);
                    let days = ['Воскресенье','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота'],
                        months = ['янв','фев','мар','апр','май','июн','июл','авг','сен','окт','ноя','дек'],
                        m = newdate.getMonth();
                    nd = newdate.getDay();
                    d = newdate.getDate();

                    let html = "<td>" + days[nd] + "</td><td>" +name +"</td><td>" + d + " " + months[m] + "</td><td>" + time + "</td><td style = 'display: none'>" + newdate + "</td><td class='button'><button type='button' class = 'upd' value = '1' data-id = '3'>Редактировать</button></td><td class='button'><button type='button' class='delete' value = '1' data-id = '3'>Удалить</button></td>";                         
                    document.getElementById(i).innerHTML = html;
                    document.querySelector('#modalupd').classList.remove('active');
        
                }else{
                    if (data.type === 1) {
                        data.fields.forEach(function (field) {
                            $(`input[name = "${field}"]`).addClass('error');
                        });
                    $('.msg').removeClass('none').text(data.message);
                   }
                }   
            }    
        });
    });

    $('.no').click(function() {
        document.querySelector('#modalupd').classList.remove('active');
    });
});

/*
    Удаление совещаний
*/

$('.delete').click(function() {
    let id = $(this).attr('data-id'),
        that = this;

    document.querySelector('#modaldel').classList.add('active');
    
    $('.yes').click(function(){
           $.ajax({
            url:"core/delmeet.php",
            type: 'POST',
            dataType:'json',
            data: {
                id: id,
            },
            success: function (data){
                if (data.status) {
                    $(that).closest('tr').remove();
                }
                else{
                    $('.msg').removeClass('none').text(data.message);
                }
                document.querySelector('#modaldel').classList.remove('active');
    
            }
        });
    });
    $('.no').click(function() {
        document.querySelector('#modaldel').classList.remove('active');
    });
    
});