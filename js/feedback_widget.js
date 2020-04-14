document.querySelector("#feedback-widget-form").addEventListener("submit", function(event){
    event.preventDefault()

    let getUrl = window.location;
    let baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    let url = baseUrl + "/wp-json/feedback-widget/v1/feedback"
    
    let data = {}
    data.question = document.querySelector(".question-class").innerText
    data.feedback  = document.querySelector(".feedback-class").value
    let post_request = JSON.stringify(data);

    document.querySelector(".button-class").disabled = true
    document.querySelector(".button-class").innerText = "Loading"

    let xhr = new XMLHttpRequest()
    xhr.open('POST', url)
    xhr.setRequestHeader('Content-type','application/json; charset=utf-8')
    xhr.send(post_request)

    xhr.addEventListener('load', () => {
        document.querySelector(".button-class").innerText = "Thank you!"
        setTimeout(() => { 
            document.querySelector(".button-class").disabled = false
            document.querySelector(".button-class").innerText = "Submit Feedback"
        }, 3000);
    })
})


