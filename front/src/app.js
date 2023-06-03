import './styles.css'
import axios from 'axios';

const form = document.getElementById('form')
const input = form.querySelector('#link-input')
const submitBtn = form.querySelector('#submit-btn')

form.addEventListener('submit', submitHandler)

async function submitHandler(event) {
    event.preventDefault()
    let formdata = new FormData()
    formdata.append("source", input.value)
    await axios.post("http://0.0.0.0:8001/link/create", formdata)
        .then(response => createModal(response.data.data.link))
        .catch(error => alert(error.response.data))
}

function createModal(shortLink) {
    const modal = document.createElement('div')
    modal.classList.add('modal')
    modal.innerHTML = `
        <h1>Your short link:</h1>
        <hr>
        <div class="modal-content">
            <a href="${shortLink}" id="copyLink" class="copyLink">
                ${shortLink}
            </a>
            <br>
            <button onclick="navigator.clipboard.writeText('${shortLink}')" class="mui-btn mui-btn--raised mui-btn--primary">Copy</button>
        </div>
    `
    mui.overlay('on', modal)
}

//
