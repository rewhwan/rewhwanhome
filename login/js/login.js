function check_input() {
    if (!document.login_form.id.value)
    {
        alert("아이디를 입력하세요");    
        document.login_form.id.focus();
        return;
    }

    if (!document.login_form.pass.value)
    {
        alert("비밀번호를 입력하세요");    
        document.login_form.pass.focus();
        return;
    }
    document.login_form.submit();
}

function check_keypress(event) {
    if(event.keyCode == '13') {
        check_input();
    }
}

window.onload = function () {
    let loginForm = document.getElementById("login_form");
    let inputID = loginForm.querySelector("#id");
    inputID.focus();
}