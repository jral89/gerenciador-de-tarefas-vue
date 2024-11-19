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
                    url: '/login_auth', // URL da sua rota de login no Laravel
                    method: 'POST',
                    data: {
                        email: this.email,
                        password: this.password,
                        _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token para proteger a requisição
                    },
                    success: (response) => {
                        if (response.success) {
                            alert("sucesso");
                            // Redireciona para a página desejada após o login bem-sucedido
                            //window.location.href = response.redirect;
                        }
                    },
                    error: (error) => {
                        alert("erro");
                        console.log(error);
                        // Mostra a mensagem de erro caso o login falhe
                        this.errorMessage = error.responseJSON.message || 'Erro ao realizar login.';
                    }
                });
            }
        }
    }
</script>