<?php
/*
Template Name: Contact
*/
get_header();

// Processa o formulário se enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);

    // Aqui você pode adicionar a lógica para enviar o e-mail
    // Por exemplo, usando wp_mail() ou outro método de sua escolha

    $success_message = "Sua mensagem foi enviada com sucesso!";
}

?>
<section id="container">
    <article class="container">
        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header>

        <div id="contact">
            <div class="content">
                <?php the_content(); ?>
            </div>
            <div class="content">
            <?php
            
            
            if (isset($success_message)) {
                echo '<p class="success-message">' . esc_html($success_message) . '</p>';
            }
            ?>
                <form action="<?php echo esc_url(get_permalink()); ?>" method="post" class="contact-form">
                    <div class="form-group">
                        <label for="name"><?php esc_html_e('Name:', 'norder-monetization'); ?></label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email"><?php esc_html_e('E-mail:', 'norder-monetization'); ?></label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="subject"><?php esc_html_e('Subject:', 'norder-monetization'); ?></label>
                        <input type="text" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="message"><?php esc_html_e('Message:', 'norder-monetization'); ?></label>
                        <textarea id="message" name="message" required></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit"><?php esc_html_e('Send', 'norder-monetization'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </article>
</section>
<?php get_footer(); ?>