<footer class="app-footer">
    <div class="footer-content">
        <div class="footer-links">
            <a href="<?php echo base_url('about'); ?>">About</a>
            <a href="<?php echo base_url('privacy'); ?>">Privacy Policy</a>
            <a href="<?php echo base_url('terms'); ?>">Terms</a>
            <a href="<?php echo base_url('contact'); ?>">Contact</a>
        </div>
        <div class="footer-copyright">
            &copy; <?php echo date('Y'); ?> One at a Time. All rights reserved.
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('.post-textarea');
    const counter = document.querySelector('.char-counter');
    
    if (textarea && counter) {
        textarea.addEventListener('input', function() {
            const remaining = 180 - this.value.length;
            counter.textContent = remaining + ' characters remaining';
            
            // Optional: Change color when getting low
            if (remaining < 20) {
                counter.style.color = '#ff0000';
            } else {
                counter.style.color = '#666';
            }
        });
    }
});
</script>

<style>
    .app-footer {
        background-color: #f8f9fa;
        padding: 20px 0;
        border-top: 1px solid #eaeaea;
        margin-top: 40px;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        text-align: center;
    }

    .footer-links {
        margin-bottom: 10px;
    }

    .footer-links a {
        color: #666;
        text-decoration: none;
        margin: 0 10px;
        font-size: 14px;
    }

    .footer-links a:hover {
        color: #007bff;
    }

    .footer-copyright {
        color: #999;
        font-size: 13px;
    }
</style>
</body>

</html>