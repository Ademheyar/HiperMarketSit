
  function sendAjaxRequest(url, method, itemsData, successCallback, errorCallback) {
    console.log('going to read table');
    var xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
        successCallback(xhr.responseText);
        } else {
        errorCallback(xhr.status);
        }
        }
    };
    xhr.send(itemsData);
  }
