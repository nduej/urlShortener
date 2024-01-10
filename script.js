//Selecting all Required Elements
const copyToClipBoard = document.getElementById("copyInput");
const saveToolTip = document.getElementById("copyIcon")

const form = document.querySelector(".wrapper form"),
fullURL = form.querySelector("input"),
shortenBtn  = form.querySelector("button"),
blurEffect  = document.querySelector(".blur-effect"),
popupBox  = document.getElementById("popup-box"),
shortenURL  = popupBox.querySelector("input");

const hash = window.location.search.substring(6)

form.onsubmit = (e)=>{
    e.preventDefault(); //Preventing form from submitting
}

shortenBtn.onclick = ()=>{
    //Start Ajax
    let xhr = new XMLHttpRequest(); //Creating xhr object
    xhr.open("POST", "php/url-control.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){ //if ajax request status is Ok/Successful
            let data = xhr.response;
            if(data.length <= 5){
                blurEffect.style.display = "block";
                popupBox.classList.add("show");
                
                let domain = "localhost/urlShortener/?hash=";
                shortenURL.value = domain + data;
            }else{
                alert(data);
            }
        }
    }
    //let's send from data to php file
    let formData = new FormData(form); //Creating new FormData Object
    xhr.send(formData); //Sending form value to Php
}

saveToolTip.onclick = () => {
    copyToClipBoard.select();
    copyToClipBoard.setSelectionRange(0,9999);

    navigator.clipboard.writeText(copyToClipBoard.value);

    saveToolTip.innerHTML = "Copied"
}

console.log(hash)

function getStringFromHash(hash) {
    fetch("php/url-control.php?hash=" + hash, {
        method: 'GET'
    })
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text();
        })
        .then(data => {
            window.location.href = data;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

if(hash != ""){
    getStringFromHash(hash);
}
// getStringFromHash('d5a94');

