    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Cabinet Dr. Dupont</h3>
                    <p>Votre santé dentaire, notre priorité</p>
                </div>
                <div class="footer-section">
                    <h4>Horaires</h4>
                    <p>Lundi - Vendredi: 9h00 - 18h00</p>
                    <p>Samedi - Dimanche: Fermé</p>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <p>Email: <?= CONTACT_EMAIL ?></p>
                    <p>Tél: 01 23 45 67 89</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> Cabinet Dr. Dupont. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    
    <!-- Mobile Menu Script -->
    <script src="<?= APP_URL ?>/assets/js/mobile-menu.js?v=<?= time() ?>"></script>
</body>
</html>
