<?php
include("Layout_KhachHang_Header.php");
include("connection.php");

// Lấy danh sách sản phẩm ăn vặt để quay
$query = "SELECT s.MaSP, s.TenSP, s.GiaBan, s.AnhBia, l.TenLoaiSP 
          FROM sanpham s 
          LEFT JOIN loaisanpham l ON s.MaLSP = l.MaLSP 
          WHERE s.HienThiSanPham = 1 
          ORDER BY RAND()";
$result = mysqli_query($con, $query);

$products = [];
$rarities = ['common', 'uncommon', 'rare', 'mythical', 'legendary'];
$rarityColors = [
    'common' => '#b0c3d9',     // xanh xám
    'uncommon' => '#5e98d9',   // xanh dương
    'rare' => '#4b69ff',       // lam đậm
    'mythical' => '#d32ce6',   // tím
    'legendary' => '#eb4b4b'   // đỏ covert
];

while ($row = mysqli_fetch_assoc($result)) {
    $imgFile = $row['AnhBia'] ?? '';
    $imgSrc = (!empty($imgFile) && file_exists('../../Images/ImgProducts/' . $imgFile))
        ? '../../Images/ImgProducts/' . $imgFile
        : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=500&q=80';
    
    // Phân phẩm cấp theo mức giá cho phong cách CS:GO
    $price = (int) $row['GiaBan'];
    if ($price < 35000) {
        $rarity = 'common';
    } elseif ($price < 50000) {
        $rarity = 'uncommon';
    } elseif ($price < 75000) {
        $rarity = 'rare';
    } elseif ($price < 100000) {
        $rarity = 'mythical';
    } else {
        $rarity = 'legendary';
    }

    $products[] = [
        'id' => (int) $row['MaSP'],
        'name' => $row['TenSP'],
        'price' => $price,
        'price_formatted' => number_format($price, 0, ',', '.') . ' VNĐ',
        'image' => $imgSrc,
        'category' => $row['TenLoaiSP'] ?? 'Ăn vặt',
        'rarity' => $rarity,
        'color' => $rarityColors[$rarity]
    ];
}
$productsJson = json_encode($products);
?>

<style>
    .case-wrapper {
        max-width: 1100px;
        margin: 30px auto;
        padding: 24px;
        background: radial-gradient(circle at center, #1b2838 0%, #0e141b 100%);
        border-radius: 20px;
        border: 2px solid #2a475e;
        box-shadow: 0 20px 45px rgba(0,0,0,0.6);
        color: #fff;
        text-align: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .case-title {
        font-size: 2.2rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #e5a93b;
        text-shadow: 0 0 20px rgba(229, 169, 59, 0.6);
        margin-bottom: 8px;
    }

    .case-subtitle {
        color: #8f98a0;
        font-size: 1.05rem;
        margin-bottom: 24px;
    }

    /* CSGO Roulette Box */
    .roulette-container {
        position: relative;
        width: 100%;
        height: 240px;
        background: #101822;
        border: 3px solid #ffaa00;
        border-radius: 14px;
        overflow: hidden;
        margin: 20px 0 30px;
        box-shadow: inset 0 0 30px rgba(0, 0, 0, 0.8), 0 0 25px rgba(255, 170, 0, 0.2);
    }

    /* Red indicator line */
    .roulette-needle {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        width: 4px;
        background: #ff3333;
        transform: translateX(-50%);
        z-index: 20;
        box-shadow: 0 0 14px #ff0000, 0 0 6px #fff;
    }

    .roulette-needle::before, .roulette-needle::after {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
    }
    .roulette-needle::before {
        top: 0;
        border-top: 12px solid #ff3333;
    }
    .roulette-needle::after {
        bottom: 0;
        border-bottom: 12px solid #ff3333;
    }

    /* Items Track */
    .roulette-track {
        display: flex;
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        will-change: transform;
    }

    .case-card {
        flex: 0 0 190px;
        width: 190px;
        height: 100%;
        padding: 14px 10px;
        box-sizing: border-box;
        border-right: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(180deg, #182330 0%, #121922 100%);
        position: relative;
    }

    .case-card-border {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 5px;
    }

    .case-card img {
        width: 120px;
        height: 90px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
        filter: drop-shadow(0 6px 12px rgba(0,0,0,0.5));
    }

    .case-card .name {
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        line-height: 1.3;
        height: 34px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .case-card .price {
        font-size: 12px;
        font-weight: 700;
        margin-top: 4px;
    }

    /* Control Buttons */
    .case-actions {
        display: flex;
        justify-content: center;
        gap: 16px;
        margin-bottom: 25px;
    }

    .btn-spin {
        background: linear-gradient(180deg, #5cba47 0%, #439233 100%);
        border: 2px solid #71d859;
        color: #fff;
        padding: 14px 44px;
        font-size: 1.3rem;
        font-weight: 800;
        border-radius: 12px;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        box-shadow: 0 10px 24px rgba(67, 146, 51, 0.4);
        transition: transform 0.15s ease, filter 0.15s ease;
    }
    .btn-spin:hover:not(:disabled) {
        transform: translateY(-2px);
        filter: brightness(1.15);
    }
    .btn-spin:active:not(:disabled) {
        transform: translateY(1px);
    }
    .btn-spin:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        box-shadow: none;
    }

    /* Winning Modal */
    .winner-overlay {
        position: fixed;
        inset: 0;
        background: rgba(5, 8, 12, 0.88);
        display: none;
        place-items: center;
        z-index: 100000;
        backdrop-filter: blur(5px);
        animation: fadeIn 0.3s ease;
    }

    .winner-box {
        background: radial-gradient(circle at center, #233448 0%, #101721 100%);
        border: 2px solid #e5a93b;
        box-shadow: 0 0 50px rgba(229, 169, 59, 0.5);
        border-radius: 20px;
        padding: 32px;
        max-width: 460px;
        width: 90%;
        text-align: center;
        animation: scaleUp 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .winner-box img {
        width: 220px;
        height: 160px;
        object-fit: cover;
        border-radius: 14px;
        border: 3px solid #e5a93b;
        margin: 18px auto;
        box-shadow: 0 12px 28px rgba(0,0,0,0.6);
    }

    .winner-box h3 {
        font-size: 1.6rem;
        color: #fff;
        margin-bottom: 8px;
        font-weight: 800;
    }

    .winner-box .win-price {
        color: #71d859;
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 22px;
    }

    .btn-order-now {
        background: linear-gradient(135deg, #d65a2b, #7a2d1d);
        border: none;
        color: #fff;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 1.1rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
    }

    .btn-close-winner {
        background: #344658;
        border: none;
        color: #fff;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes scaleUp { from { transform: scale(0.7); opacity: 0; } to { transform: scale(1); opacity: 1; } }
</style>

<div class="case-wrapper">
    <div class="case-title">🎁 Mở Hòm Món Ăn CS:GO</div>
    <div class="case-subtitle">Hôm nay chưa biết ăn gì? Hãy để thần may mắn chọn giúp món ăn vặt cho bạn!</div>

    <div class="roulette-container">
        <div class="roulette-needle"></div>
        <div class="roulette-track" id="rouletteTrack">
            <!-- Cards rendered here by JS -->
        </div>
    </div>

    <div class="case-actions">
        <button class="btn-spin" id="spinButton" onclick="startSpin()">MỞ HÒM NGAY</button>
    </div>
</div>

<!-- Modal Trúng Món -->
<div class="winner-overlay" id="winnerModal">
    <div class="winner-box">
        <h4 style="color:#e5a93b; text-transform:uppercase; letter-spacing:1px; margin-top:0;">🎉 CHÚC MỪNG BẠN ĐÃ MỞ TRÚNG 🎉</h4>
        <img id="winnerImage" src="" alt="Winner">
        <h3 id="winnerName"></h3>
        <div class="win-price" id="winnerPrice"></div>
        <div>
            <a id="winnerLink" href="#" class="btn-order-now">Xem & Đặt Ngay</a>
            <button class="btn-close-winner" onclick="closeWinnerModal()">Đóng</button>
        </div>
    </div>
</div>

<script>
    const items = <?php echo $productsJson; ?>;
    const cardWidth = 190;
    const totalTrackItems = 65; // Số ô lướt ngang
    const track = document.getElementById('rouletteTrack');
    const spinBtn = document.getElementById('spinButton');
    let isSpinning = false;
    let trackItems = [];

    // Tạo âm thanh tick ngắn bằng Web Audio API không cần load file ngoài
    const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    function playTickSound() {
        try {
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'triangle';
            osc.frequency.setValueAtTime(650, audioCtx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(100, audioCtx.currentTime + 0.04);
            gain.gain.setValueAtTime(0.2, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.04);
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.04);
        } catch (e) {}
    }

    function initTrack() {
        track.innerHTML = '';
        trackItems = [];
        for (let i = 0; i < totalTrackItems; i++) {
            const randomItem = items[Math.floor(Math.random() * items.length)];
            trackItems.push(randomItem);

            const card = document.createElement('div');
            card.className = 'case-card';
            card.innerHTML = `
                <img src="${randomItem.image}" alt="${randomItem.name}">
                <div class="name">${randomItem.name}</div>
                <div class="price" style="color:${randomItem.color}">${randomItem.price_formatted}</div>
                <div class="case-card-border" style="background:${randomItem.color}"></div>
            `;
            track.appendChild(card);
        }
        track.style.transition = 'none';
        track.style.transform = 'translateX(0px)';
    }

    initTrack();

    function startSpin() {
        if (isSpinning || items.length === 0) return;
        isSpinning = true;
        spinBtn.disabled = true;

        initTrack();

        // Món chiến thắng nằm ở index 52
        const winningIndex = 52;
        const winningItem = trackItems[winningIndex];

        // Tính vị trí dừng ngay tâm kim chỉ (với độ lệch ngẫu nhiên nhẹ trong khung thẻ)
        const containerWidth = track.parentElement.offsetWidth;
        const randomOffset = Math.floor(Math.random() * (cardWidth - 40)) + 20; // dao động ngẫu nhiên trong card
        const targetTranslate = (winningIndex * cardWidth) + randomOffset - (containerWidth / 2);

        const duration = 6500; // 6.5s mượt mà chuẩn CS:GO
        track.style.transition = `transform ${duration}ms cubic-bezier(0.12, 0.8, 0.15, 1)`;
        track.style.transform = `translateX(-${targetTranslate}px)`;

        // Phát âm thanh tiếng tick khi card trượt qua
        let lastPassedCard = 0;
        const startTime = performance.now();

        function checkTick(time) {
            if (!isSpinning) return;
            const progress = (time - startTime) / duration;
            if (progress < 1) {
                const currentMatrix = window.getComputedStyle(track).transform;
                if (currentMatrix && currentMatrix !== 'none') {
                    const currentX = Math.abs(parseFloat(currentMatrix.split(',')[4]));
                    const passedCard = Math.floor((currentX + (containerWidth / 2)) / cardWidth);
                    if (passedCard !== lastPassedCard) {
                        lastPassedCard = passedCard;
                        playTickSound();
                    }
                }
                requestAnimationFrame(checkTick);
            }
        }
        requestAnimationFrame(checkTick);

        setTimeout(() => {
            isSpinning = false;
            spinBtn.disabled = false;
            showWinnerModal(winningItem);
        }, duration + 350);
    }

    function showWinnerModal(item) {
        document.getElementById('winnerImage').src = item.image;
        document.getElementById('winnerName').textContent = item.name;
        document.getElementById('winnerPrice').textContent = item.price_formatted;
        document.getElementById('winnerLink').href = 'details.php?MaSP=' + item.id;
        document.getElementById('winnerModal').style.display = 'grid';
    }

    function closeWinnerModal() {
        document.getElementById('winnerModal').style.display = 'none';
    }
</script>

<?php include("Layout_KhachHang_Footer.php"); ?>
