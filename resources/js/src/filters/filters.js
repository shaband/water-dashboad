import Vue from 'vue'
import get from 'lodash/get'

Vue.filter('title', function (value, replacer = '_') {
    if (!value) return ''
    value = value.toString()

    const arr = value.split(replacer)
    const capitalized_array = []
    arr.forEach((word) => {
        const capitalized = word.charAt(0).toUpperCase() + word.slice(1)
        capitalized_array.push(capitalized)
    })
    return capitalized_array.join(' ')
})

Vue.filter('get', (value, index, def = null) => {
    return get(value, index, def)
})
