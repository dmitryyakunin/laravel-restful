const versionAPI = 'v2'
const endpoint = 'http://laravel-restful/api/' + versionAPI

const getSearchRoute = (name, param1, param2) => {
    if (versionAPI === 'v1') {
        return endpoint + '/products/search/' + name + '/' + param1 + '/' + param2
    } else {
        if (param2 !== 'null') {
            return endpoint + '/products/search/' + name + '/' + param1 + '/' + param2
        } else {
            return endpoint + '/products/search/' + name + '/' + param1
        }
    }
}

export default {
    endpoint,
    getSearchRoute
}
