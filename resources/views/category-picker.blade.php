<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hitster Bingo - Categorie Kiezer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes discoGradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes discoRotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes discoPulse {
            0%, 100% {
                opacity: 0.3;
            }
            50% {
                opacity: 0.6;
            }
        }

        @keyframes discoShimmer {
            0% {
                background-position: -200% center;
            }
            100% {
                background-position: 200% center;
            }
        }

        .disco-bg {
            background: linear-gradient(
                45deg,
                #ff006e,
                #8338ec,
                #3a86ff,
                #06ffa5,
                #ffbe0b,
                #fb5607,
                #ff006e
            );
            background-size: 400% 400%;
            animation: discoGradient 8s ease infinite;
            position: relative;
            overflow: hidden;
        }

        .disco-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            animation: discoRotate 20s linear infinite;
        }

        .disco-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                repeating-linear-gradient(
                    0deg,
                    transparent,
                    transparent 2px,
                    rgba(255, 255, 255, 0.03) 2px,
                    rgba(255, 255, 255, 0.03) 4px
                );
            animation: discoPulse 3s ease-in-out infinite;
        }

        .disco-overlay {
            position: relative;
            z-index: 1;
        }

        .disco-shine {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent 30%,
                rgba(255, 255, 255, 0.1) 50%,
                transparent 70%
            );
            animation: discoShimmer 4s linear infinite;
            pointer-events: none;
        }
    </style>
</head>
<body class="disco-bg text-white min-h-screen flex items-center justify-center p-6">
    <div class="disco-shine"></div>
    <div class="w-full max-w-4xl mx-auto disco-overlay">
    <div class="w-full max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold mb-2 text-[#1b1b18] dark:text-white drop-shadow-lg">Hitster Bingo</h1>
                <p class="text-lg text-[#706f6c] dark:text-[#A1A09A]">Categorie Kiezer</p>
            </div>

        <div class="bg-white/95 dark:bg-[#161615]/95 backdrop-blur-sm rounded-lg shadow-2xl p-8 border-2 border-white/20">
            <!-- Timer Display -->
            <div class="text-center mb-8">
                <div id="timer" class="text-6xl font-bold text-[#f53003] dark:text-[#FF4433] mb-4">
                    <span id="timer-value">3</span>
                </div>
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">seconden</p>
            </div>

            <!-- Spinning Wheel Container -->
            <div class="relative flex items-center justify-center mb-8" style="height: 400px;">
                <div id="wheel-container" class="relative w-80 h-80">
                    <!-- Wheel -->
                    <svg id="wheel" class="w-full h-full transform transition-transform duration-100" viewBox="0 0 400 400">
                        <defs>
                            <pattern id="wheel-pattern" x="0" y="0" width="400" height="400" patternUnits="userSpaceOnUse">
                                <!-- Categories will be drawn here -->
                            </pattern>
                        </defs>
                        <circle cx="200" cy="200" r="190" fill="url(#wheel-pattern)" stroke="#1b1b18" stroke-width="4" class="dark:stroke-[#EDEDEC]"/>
                        <circle cx="200" cy="200" r="30" fill="#f53003" class="dark:fill-[#FF4433]"/>
                    </svg>

                    <!-- Pointer -->
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-2 z-10">
                        <div class="w-0 h-0 border-l-20 border-l-transparent border-r-20 border-r-transparent border-t-30 border-t-[#f53003] dark:border-t-[#FF4433] drop-shadow-lg"></div>
                    </div>
                </div>
            </div>

            <!-- Current Category Display -->
            <div class="text-center mb-8">
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-2">Huidige categorie:</p>
                <div id="current-category" class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] min-h-12 flex items-center justify-center">
                    <span id="category-text">-</span>
                </div>
            </div>

            <!-- Result Display (shown after timer) -->
            <div id="result" class="hidden text-center mb-8">
                <div class="bg-[#fff2f2] dark:bg-[#1D0002] rounded-lg p-6 border-2 border-[#f53003] dark:border-[#FF4433]">
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-2">De gekozen categorie is:</p>
                    <p id="result-category" class="text-4xl font-bold text-[#f53003] dark:text-[#FF4433]"></p>
                </div>
            </div>

            <!-- Controls -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <button
                    id="spin-button"
                    class="px-8 py-3 bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18] rounded-lg font-semibold hover:bg-black dark:hover:bg-white transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Start Draaien
                </button>
                <button
                    id="reset-button"
                    class="px-8 py-3 bg-[#dbdbd7] dark:bg-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC] rounded-lg font-semibold hover:bg-[#c4c4c0] dark:hover:bg-[#62605b] transition-colors hidden"
                >
                    Opnieuw
                </button>
            </div>

            <!-- Settings -->
            <div class="mt-8 pt-8 border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <label for="timer-duration" class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        Timer duur (seconden):
                    </label>
                    <input
                        type="number"
                        id="timer-duration"
                        min="1"
                        max="10"
                        value="3"
                        class="w-20 px-3 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC]"
                    >
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        const categories = @json($categories);
        let currentIndex = 0;
        let isSpinning = false;
        let timerInterval = null;
        let spinInterval = null;
        let timeRemaining = 3;
        let selectedCategory = null;

        // Draw wheel segments
        function drawWheel() {
            const svg = document.getElementById('wheel');
            const segments = categories.length;
            const anglePerSegment = 360 / segments;
            const radius = 190;
            const centerX = 200;
            const centerY = 200;

            // Clear existing paths
            const existingPaths = svg.querySelectorAll('.segment');
            existingPaths.forEach(path => path.remove());

            // Colors for segments
            const colors = [
                '#f53003', // Red
                '#F8B803', // Yellow
                '#3b82f6', // Blue
                '#10b981'  // Green
            ];

            categories.forEach((category, index) => {
                const startAngle = (index * anglePerSegment - 90) * (Math.PI / 180);
                const endAngle = ((index + 1) * anglePerSegment - 90) * (Math.PI / 180);

                // Create path for segment
                const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                const x1 = centerX + radius * Math.cos(startAngle);
                const y1 = centerY + radius * Math.sin(startAngle);
                const x2 = centerX + radius * Math.cos(endAngle);
                const y2 = centerY + radius * Math.sin(endAngle);

                const largeArc = anglePerSegment > 180 ? 1 : 0;

                path.setAttribute('d', `M ${centerX} ${centerY} L ${x1} ${y1} A ${radius} ${radius} 0 ${largeArc} 1 ${x2} ${y2} Z`);
                path.setAttribute('fill', colors[index % colors.length]);
                path.setAttribute('stroke', '#1b1b18');
                path.setAttribute('stroke-width', '2');
                path.setAttribute('class', 'segment dark:stroke-[#EDEDEC]');
                svg.appendChild(path);

                // Add text
                const textAngle = (index * anglePerSegment + anglePerSegment / 2 - 90) * (Math.PI / 180);
                const textRadius = radius * 0.7;
                const textX = centerX + textRadius * Math.cos(textAngle);
                const textY = centerY + textRadius * Math.sin(textAngle);

                const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                text.setAttribute('x', textX);
                text.setAttribute('y', textY);
                text.setAttribute('text-anchor', 'middle');
                text.setAttribute('dominant-baseline', 'middle');
                text.setAttribute('fill', '#ffffff');
                text.setAttribute('font-size', '16');
                text.setAttribute('font-weight', 'bold');
                text.setAttribute('class', 'segment-text');
                text.setAttribute('transform', `rotate(${index * anglePerSegment + anglePerSegment / 2}, ${textX}, ${textY})`);

                // Split long text into lines (max 2 lines)
                const words = category.split(' ');
                const midPoint = Math.ceil(words.length / 2);
                const line1 = words.slice(0, midPoint).join(' ');
                const line2 = words.slice(midPoint).join(' ');

                const tspan1 = document.createElementNS('http://www.w3.org/2000/svg', 'tspan');
                tspan1.setAttribute('x', textX);
                tspan1.setAttribute('dy', line2 ? '-0.4em' : '0');
                tspan1.textContent = line1;
                text.appendChild(tspan1);

                if (line2) {
                    const tspan2 = document.createElementNS('http://www.w3.org/2000/svg', 'tspan');
                    tspan2.setAttribute('x', textX);
                    tspan2.setAttribute('dy', '1.2em');
                    tspan2.textContent = line2;
                    text.appendChild(tspan2);
                }

                svg.appendChild(text);
            });
        }

        // Get category index based on rotation
        // Pointer is at top (0 degrees), so we need to calculate which category is under the pointer
        function getCategoryFromRotation(rotation) {
            // Normalize rotation to 0-360
            const normalizedRotation = ((rotation % 360) + 360) % 360;

            // Pointer is at top (0 degrees in screen coordinates)
            // In the SVG, category 0 starts at -90 degrees (top position)
            // When wheel rotates clockwise, we need to find which category is now at top
            // Each category takes 360 / categories.length degrees
            const anglePerSegment = 360 / categories.length;

            // When rotation is 0, category 0 is at top (which is -90 degrees in SVG coordinates)
            // So we need to add 90 degrees offset, then account for rotation
            // The formula: (offset + rotation) / anglePerSegment gives us the category
            const adjustedAngle = (90 + normalizedRotation) % 360;
            const categoryIndex = Math.floor(adjustedAngle / anglePerSegment);

            return categoryIndex % categories.length;
        }

        function updateCategoryDisplay(rotation = null) {
            const categoryText = document.getElementById('category-text');
            if (rotation !== null) {
                currentIndex = getCategoryFromRotation(rotation);
            }
            categoryText.textContent = categories[currentIndex];
        }

        function startSpin() {
            if (isSpinning) return;

            isSpinning = true;
            const spinButton = document.getElementById('spin-button');
            const resetButton = document.getElementById('reset-button');
            const resultDiv = document.getElementById('result');
            const timerDuration = parseInt(document.getElementById('timer-duration').value) || 3;

            spinButton.disabled = true;
            resultDiv.classList.add('hidden');
            timeRemaining = timerDuration;
            document.getElementById('timer-value').textContent = timeRemaining;

            // Reset wheel position
            currentIndex = 0;
            const wheel = document.getElementById('wheel');
            wheel.style.transform = 'rotate(0deg)';
            updateCategoryDisplay(0);

            // Start spinning animation
            let rotation = 0;
            const spinSpeed = 50; // milliseconds per segment change

            spinInterval = setInterval(() => {
                rotation += 360 / categories.length;
                wheel.style.transform = `rotate(${rotation}deg)`;
                updateCategoryDisplay(rotation);
            }, spinSpeed);

            // Start timer countdown
            timerInterval = setInterval(() => {
                timeRemaining--;
                document.getElementById('timer-value').textContent = timeRemaining;

                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    clearInterval(spinInterval);

                    // Select random category
                    const randomIndex = Math.floor(Math.random() * categories.length);
                    selectedCategory = categories[randomIndex];

                    // Calculate final rotation to stop at selected category
                    // Pointer is at top (0 degrees)
                    // Category 0 is at top when rotation = 270 degrees (or -90 degrees)
                    // Category N is at top when rotation = (270 + N * 90) % 360
                    const anglePerSegment = 360 / categories.length;
                    const currentCategoryIndex = getCategoryFromRotation(rotation);

                    // Target rotation for selected category to be at top
                    // We use 270 as base because category 0 starts at -90 (which is 270 normalized)
                    const baseRotation = 270;
                    const targetRotationForCategory = (baseRotation + randomIndex * anglePerSegment) % 360;

                    // Current normalized rotation
                    const currentNormalized = ((rotation % 360) + 360) % 360;

                    // Calculate how much to rotate to reach target
                    let rotationNeeded = (targetRotationForCategory - currentNormalized + 360) % 360;
                    // If more than 180, go the other way (shorter path)
                    if (rotationNeeded > 180) {
                        rotationNeeded = rotationNeeded - 360;
                    }

                    // Add multiple full rotations for effect (3-5 rotations)
                    const fullRotations = 3 + Math.random() * 2; // 3-5 rotations
                    const finalRotation = rotation + rotationNeeded + (360 * fullRotations);

                    // Smooth stop animation
                    let currentRotation = rotation;
                    const targetRotation = finalRotation;
                    const steps = 40;
                    let stepCount = 0;

                    const slowDownInterval = setInterval(() => {
                        stepCount++;
                        const progress = stepCount / steps;
                        // Ease out cubic for smooth deceleration
                        const easeOut = 1 - Math.pow(1 - progress, 3);
                        const newRotation = currentRotation + (targetRotation - currentRotation) * easeOut;

                        wheel.style.transform = `rotate(${newRotation}deg)`;
                        updateCategoryDisplay(newRotation);

                        if (stepCount >= steps) {
                            clearInterval(slowDownInterval);

                            // Final position - ensure exact alignment
                            // Calculate exact rotation for selected category to be at top (pointer position)
                            const baseRotation = 270; // Category 0 is at top when rotation is 270
                            const exactRotationForCategory = (baseRotation + randomIndex * anglePerSegment) % 360;

                            // Calculate how many full rotations we've done
                            const initialFullRotations = Math.floor(rotation / 360);
                            // Add the extra full rotations for effect
                            const totalFullRotations = initialFullRotations + fullRotations;

                            // Final exact rotation
                            const exactFinalRotation = (totalFullRotations * 360) + exactRotationForCategory;

                            wheel.style.transform = `rotate(${exactFinalRotation}deg)`;
                            currentIndex = randomIndex;
                            updateCategoryDisplay(exactFinalRotation);

                            // Verify the category is correct (double check)
                            const finalCategoryIndex = getCategoryFromRotation(exactFinalRotation);
                            if (finalCategoryIndex !== randomIndex) {
                                // Fine-tune if needed (shouldn't happen, but just in case)
                                const fineTune = ((randomIndex - finalCategoryIndex + categories.length) % categories.length) * anglePerSegment;
                                const correctedRotation = exactFinalRotation + fineTune;
                                wheel.style.transform = `rotate(${correctedRotation}deg)`;
                                currentIndex = randomIndex;
                                updateCategoryDisplay(correctedRotation);
                            }

                            // Show result
                            document.getElementById('result-category').textContent = selectedCategory;
                            resultDiv.classList.remove('hidden');
                            spinButton.disabled = false;
                            resetButton.classList.remove('hidden');
                            isSpinning = false;
                        }
                    }, 20);
                }
            }, 1000);
        }

        function reset() {
            clearInterval(timerInterval);
            clearInterval(spinInterval);
            isSpinning = false;
            timeRemaining = 3;
            currentIndex = 0;
            selectedCategory = null;

            document.getElementById('timer-value').textContent = timeRemaining;
            document.getElementById('category-text').textContent = '-';
            document.getElementById('result').classList.add('hidden');
            document.getElementById('reset-button').classList.add('hidden');
            document.getElementById('spin-button').disabled = false;

            const wheel = document.getElementById('wheel');
            wheel.style.transform = 'rotate(0deg)';
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            drawWheel();
            updateCategoryDisplay();

            document.getElementById('spin-button').addEventListener('click', startSpin);
            document.getElementById('reset-button').addEventListener('click', reset);
        });
    </script>
</body>
</html>

