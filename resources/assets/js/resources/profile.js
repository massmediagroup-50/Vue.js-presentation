export function load() {
    return axios.get('/api/profile', { params: { include: 'user,addresses,contacts' } })
}

export function update(profile) {
    return axios.post('/api/profile', { profile })
}

export function deactivate({ slug }) {
    return axios.delete(`/profile/${slug}`)
}