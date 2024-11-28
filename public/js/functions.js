function verifyNum(e) {
    const inputValue = e.target.value;
    const onlyNumbers = inputValue.replace(/[^\d]/g, ''); // оставляем только цифры
    return onlyNumbers;
}

function verifyNumDouble(e) {
    const inputValue = e.target.value;
    const onlyNumbers = inputValue.replace(/[^0-9.]/g, ''); // оставляем только цифры
    return onlyNumbers;
}
function formatDate(date) {
    var readdate = date.getDate() + '.' + (date.getMonth()+1) + '.' + date.getFullYear();
    let [d, m, y] = readdate.split('.')
    var formatDate = `${d.padStart(2, '0')}.${m.padStart(2, '0')}.${y}`;
    return formatDate;
}
