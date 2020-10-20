function check_delete(input) {
    if(input.value != '') {
        document.getElementById("delete").checked = true;
    }
}

function check_input() {
    if (!document.board_form.subject.value)
    {
        alert("제목을 입력하세요!");
        document.board_form.subject.focus();
        return;
    }
    if (!document.board_form.content.value)
    {
        alert("내용을 입력하세요!");
        document.board_form.content.focus();
        return;
    }
    document.board_form.submit();
}