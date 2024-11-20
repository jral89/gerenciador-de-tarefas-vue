<template>
    <div class="d-flex justify-content-center align-items-center bg-light" style="height: 70vh;">
        <div class="card p-4 shadow" style="width: 400px;">
            <h2 class="text-center mb-4">Login</h2>
            <form @submit.prevent="login">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input
                        type="email"
                        v-model="email"
                        id="email"
                        class="form-control"
                        placeholder="Digite seu email"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha:</label>
                    <input
                        type="password"
                        v-model="password"
                        id="password"
                        class="form-control"
                        placeholder="Digite sua senha"
                        required
                    />
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
        </div>
    </div>
</template>

<script>
    $.get('/csrf-token', function(response) {
        $('meta[name="csrf-token"]').attr('content', response.csrfToken);
    });
    export default{
        data(){
            return {
                email: '',
                password: '',
                errorMessage: null,
            }
        },
        methods: {
            login() {
                $.ajax({
                    url: '/login_auth',
                    method: 'POST',
                    data: {
                        email: this.email,
                        password: this.password,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: (response) => {
                        if (response.success) {
                            this.$router.push('/home');
                        }
                    },
                    error: (error) => {
                        this.errorMessage = error.responseJSON.message || 'Erro ao realizar login.';
                    }
                });
            }
        }
    }
</script>