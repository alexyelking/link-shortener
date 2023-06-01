import './styles.css'
import axios from 'axios';

const form = document.getElementById('form')
const input = form.querySelector('#link-input')
const submitBtn = form.querySelector('#submit-btn')

form.addEventListener('submit', submitHandler)

async function submitHandler(event) {
    event.preventDefault()
    await axios
        .post('http://0.0.0.0:8001/link/create', {
            source: input.value,
        })
        .then(response => console.log(response))
        .catch(error => console.log(error))
}