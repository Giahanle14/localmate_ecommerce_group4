<style>
    :root {
        --primary: #1A5336;
        --bg-color: #FDFDF9;
    }
    body { background-color: var(--bg-color); font-family: 'Quicksand', sans-serif; }
    
    .success-wrapper { 
        min-height: 65vh; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        padding: 40px 20px; 
    }

    .success-box { 
        background: #fff; 
        border: 2px solid #111; 
        border-radius: 16px; 
        padding: 60px 40px; 
        text-align: center; 
        max-width: 600px; 
        width: 100%; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
        animation: slideUp 0.5s ease-out forwards;
    }

    .check-circle { 
        width: 75px; 
        height: 75px; 
        background: var(--primary); 
        border-radius: 50%; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        color: white; 
        font-size: 2.2rem; 
        margin-bottom: 25px; 
    }

    .success-box h1 { 
        font-size: 2.4rem; 
        font-weight: 800; 
        color: #111; 
        line-height: 1.3; 
        margin-bottom: 15px; 
    }

    .success-box p { 
        font-size: 1.1rem; 
        color: #555; 
        margin-bottom: 40px; 
        font-weight: 500; 
    }

    .btn-close-success { 
        background: var(--primary); 
        color: white; 
        padding: 14px 45px; 
        border-radius: 12px; 
        font-weight: 800; 
        font-size: 1.2rem; 
        text-decoration: none; 
        display: inline-block; 
        transition: 0.3s; 
        border: none; 
    }

    .btn-close-success:hover { 
        background: #123C27; 
        color: white; 
        transform: translateY(-2px); 
        box-shadow: 0 5px 15px rgba(26, 83, 54, 0.3);
    }

    @keyframes slideUp {
        0% { transform: translateY(30px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
</style>

<div class="success-wrapper">
    <div class="success-box">
        <div class="check-circle">
            <i class="fa-solid fa-check"></i>
        </div>
        <h1>Bạn đã hủy tour<br>thành công!</h1>
        <p>Hãy xem thêm các tour trải nghiệm khác của chúng mình nhé!</p>
        
        <a href="index.php?controller=mytrip" class="btn-close-success">Đóng</a>
    </div>
</div>