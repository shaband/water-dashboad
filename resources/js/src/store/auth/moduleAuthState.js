export default () => (
    {
        admin: JSON.parse(localStorage.getItem('admin')) || null,
        fcm:null,
        fcm_token:localStorage.getItem('admin_fcm_token') || null
    }
)
