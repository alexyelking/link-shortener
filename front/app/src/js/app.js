import '../css/styles.css'
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
        .then(response => console.log(response.data.data.short))
        .catch(error => alert(error.response.data.message))
}