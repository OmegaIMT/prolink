<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo ao ProLink</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f9; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; padding:40px;">

                    <tr>
                        <td>
                            <h2 style="margin-top:0; color:#2c3e50;">
                                🚀 Bem-vindo(a) ao ProLink!
                            </h2>

                            <p>Olá <strong>{{ $user->name }}</strong>,</p>

                            <p>
                                É um prazer ter você com a gente!
                            </p>

                            <p>
                                O <strong>ProLink</strong> foi criado para transformar a forma como você gerencia
                                suas oportunidades, centralizando tudo em um só lugar e ajudando você a
                                economizar tempo e aumentar sua produtividade.
                            </p>

                            <p><strong>Aqui você poderá:</strong></p>

                            <ul style="padding-left:20px;">
                                <li>📌 Organizar suas oportunidades de forma simples e eficiente</li>
                                <li>🎯 Tomar decisões mais estratégicas</li>
                                <li>🕒 Otimizar seu tempo com processos inteligentes</li>
                            </ul>

                            <p>
                                Nosso objetivo é facilitar sua rotina e dar mais controle sobre o que realmente importa.
                            </p>

                            <p style="text-align:center; margin:30px 0;">
                                <a href="{{ url('/login') }}"
                                   style="background:#2563eb; color:#ffffff; padding:12px 25px;
                                   text-decoration:none; border-radius:5px; display:inline-block;">
                                   Acessar Plataforma
                                </a>
                            </p>

                            <p style="margin-top:40px;">
                                <strong>Equipe ProLink</strong><br>
                                Gerenciando oportunidades para o seu sucesso.
                            </p>

                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>