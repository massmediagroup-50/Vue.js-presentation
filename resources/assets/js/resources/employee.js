export function add(employee) {
    return axios.post('/api/employees', { employee })
}

export function remove({ id }) {
    return axios.delete(`/api/addresses/${id}`)
}