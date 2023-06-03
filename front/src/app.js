import './styles.css'
import axios from 'axios';

const form = document.getElementById('form')
const input = form.querySelector('#link-input')
const submitBtn = form.querySelector('#submit-btn')

form.addEventListener('submit', submitHandler)

async function submitHandler(event) {
    event.preventDefault()
    let res;
    let formdata = new FormData()
    formdata.append("source", input.value)
    await axios.post("http://0.0.0.0:8001/link/create", formdata)
        .then(response => createModal(response.data.data.link))
        .catch(error => alert(error.response.data))

    // let text = document.getElementById('copyLink')
    // console.log(text)
    // console.log(typeof text)
    // text.select()
    // document.execCommand("copy")

    // input.value = ''
}

function createModal(shortLink) {
    const modal = document.createElement('div')
    modal.classList.add('modal')
    modal.innerHTML = `
        <h1>Your short link:</h1>
        <hr>
        <div class="modal-content">
            <a href="${shortLink}" id="copyLink">
                ${shortLink}
            </a>
        </div>
    `

    // shortLink.select()
    // document.execCommand("copy")
    // let text = document.getElementById("copyLink")
    // console.log(text)
    // text.addEventListener('click', getCopy)
    // function getCopy() {
    //     text.select()
    //     document.execCommand("copy");
    // }

    mui.overlay('on', modal)
}