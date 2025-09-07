<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Session\SessionInterface $session
 */
?>

<?php $view->component('start_simple'); ?>

<main class="form-register w-100 m-auto">
    <div class="container d-flex justify-content-center">
        <form action="/register" method="post" class="d-flex flex-column justify-content-center w-50 gap-2 mt-5 mb-5">
            <div class="d-flex" style="align-items: center; justify-content: space-between">
                <h2>Регистрация</h2>
                <a href="/" class="d-flex align-items-center mb-5 mb-lg-0 text-white text-decoration-none">
                    <h5 class="m-0">Кинопоиск <span class="badge bg-warning warn__badge">Lite</span></h5>
                </a>
            </div>
            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <input
                            type="text"
                            class="form-control <?php echo $session->has('name') ? 'is-invalid' : '' ?>"
                            id="name"
                            name="name"
                            placeholder="Иван Иванов"
                        >
                        <label for="name">Имя</label>
                        <?php if ($session->has('name')) { ?>
                            <div id="name" class="invalid-feedback">
                                <?php echo $session->getFlash('name')[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <input
                            type="email"
                            class="form-control <?php echo $session->has('email') ? 'is-invalid' : '' ?>"
                            id="email"
                            name="email"
                            placeholder="name@areaweb.su"
                        >
                        <label for="email">E-mail</label>
                        <?php if ($session->has('email')) { ?>
                            <div id="email" class="invalid-feedback">
                                <?php echo $session->getFlash('email')[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <input
                            type="password"
                            class="form-control <?php echo $session->has('password') ? 'is-invalid' : '' ?>"
                            id="password"
                            name="password"
                            placeholder="*********"
                        >
                        <label for="password">Пароль</label>
                        <?php if ($session->has('password')) { ?>
                            <div id="password" class="invalid-feedback">
                                <?php echo $session->getFlash('password')[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                        <input
                            type="password"
                            class="form-control"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="*********">
                        <label for="password_confirmation">Подтверждение</label>
                    </div>
                </div>
            </div>

            <div class="row g-2">
                <button class="btn btn-primary">Создать аккаунт</button>
            </div>

            <div class="m-3 d-flex justify-content-center">
                <p>Есть аккаунт? <a href="/login">Войти</a> </p>
            </div>

            <p class="mt-5 text-center mb-3 text-body-secondary">&copy; Кинопоиск Lite 2025</p>
        </form>

    </div>

</main>

<?php $view->component('end_simple'); ?>

