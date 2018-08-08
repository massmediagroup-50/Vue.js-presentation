export function add(address) {
    return axios.post('/api/addresses', { address })
}

export function remove({ id }) {
    return axios.delete(`/api/addresses/${id}`)
}