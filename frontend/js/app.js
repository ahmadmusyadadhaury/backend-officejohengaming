// API Base URL
const API_BASE = 'http://localhost:3000';

// Global state
let currentUser = null;
let currentToken = null;
let calendar = null;

// DOM elements
const app = document.getElementById('app');
const navMenu = document.getElementById('nav-menu');

// Initialize app
document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('token');
    const user = localStorage.getItem('user');

    if (token && user) {
        currentToken = token;
        currentUser = JSON.parse(user);
        showDashboard();
    } else {
        showLoginPage();
    }
});

// Authentication functions
async function login(email, password) {
    try {
        const response = await fetch(`${API_BASE}/auth/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email, password }),
        });

        const data = await response.json();

        if (response.ok) {
            currentToken = data.token;
            currentUser = data.user;
            localStorage.setItem('token', currentToken);
            localStorage.setItem('user', JSON.stringify(currentUser));
            closeLoginModal();
            showDashboard();
        } else {
            alert(data.error || 'Login failed');
        }
    } catch (error) {
        console.error('Login error:', error);
        alert('Login failed');
    }
}

function logout() {
    currentToken = null;
    currentUser = null;
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    showLoginPage();
}

// API helper functions
async function apiRequest(endpoint, options = {}) {
    const config = {
        headers: {
            'Authorization': `Bearer ${currentToken}`,
            'Content-Type': 'application/json',
            ...options.headers,
        },
        ...options,
    };

    const response = await fetch(`${API_BASE}${endpoint}`, config);
    return response;
}

// UI functions
function showLoginPage() {
    app.innerHTML = `
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Meeting Room Booking System
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Sign in to book meeting rooms
                    </p>
                </div>
                <button onclick="openLoginModal()"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Sign In
                </button>
            </div>
        </div>
    `;

    navMenu.innerHTML = '';
}

function showDashboard() {
    app.innerHTML = `
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                    <button onclick="openBookingModal()"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Book Room
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                        <span class="text-white text-sm font-bold">R</span>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Available Rooms
                                        </dt>
                                        <dd class="text-lg font-medium text-gray-900" id="rooms-count">
                                            Loading...
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                        <span class="text-white text-sm font-bold">B</span>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            My Bookings
                                        </dt>
                                        <dd class="text-lg font-medium text-gray-900" id="bookings-count">
                                            Loading...
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                        <span class="text-white text-sm font-bold">T</span>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Today's Bookings
                                        </dt>
                                        <dd class="text-lg font-medium text-gray-900" id="today-count">
                                            Loading...
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Calendar
                        </h3>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    `;

    navMenu.innerHTML = `
        <span class="text-gray-700">Welcome, ${currentUser.name}</span>
        ${currentUser.role === 'ADMIN' ? '<a href="#" onclick="showAdminPanel()" class="text-gray-500 hover:text-gray-700">Admin</a>' : ''}
        <button onclick="logout()" class="text-gray-500 hover:text-gray-700">Logout</button>
    `;

    loadDashboardData();
    initializeCalendar();
}

function showAdminPanel() {
    app.innerHTML = `
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Admin Panel</h1>
                    <button onclick="showDashboard()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Dashboard
                    </button>
                </div>

                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Room Management
                            </h3>
                            <button onclick="openAddRoomModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Room
                            </button>
                        </div>
                        <div id="rooms-list" class="space-y-4">
                            <!-- Rooms will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    loadRoomsForAdmin();
}

async function loadDashboardData() {
    try {
        // Load rooms count
        const roomsResponse = await apiRequest('/rooms');
        const rooms = await roomsResponse.json();
        document.getElementById('rooms-count').textContent = rooms.length;

        // Load bookings count
        const bookingsResponse = await apiRequest('/bookings');
        const bookings = await bookingsResponse.json();
        document.getElementById('bookings-count').textContent = bookings.length;

        // Load today's bookings count
        const today = new Date().toISOString().split('T')[0];
        const todayResponse = await apiRequest(`/bookings?date=${today}`);
        const todayBookings = await todayResponse.json();
        document.getElementById('today-count').textContent = todayBookings.length;

    } catch (error) {
        console.error('Error loading dashboard data:', error);
    }
}

async function loadRoomsForAdmin() {
    try {
        const response = await apiRequest('/rooms');
        const rooms = await response.json();

        const roomsList = document.getElementById('rooms-list');
        roomsList.innerHTML = rooms.map(room => `
            <div class="border rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-lg font-medium">${room.name}</h4>
                        <p class="text-gray-600">Capacity: ${room.capacity}</p>
                        <p class="text-gray-600">Location: ${room.location}</p>
                        <p class="text-gray-600">Facilities: ${room.facilities.join(', ')}</p>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="editRoom(${room.id})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                            Edit
                        </button>
                        <button onclick="deleteRoom(${room.id})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        `).join('');

    } catch (error) {
        console.error('Error loading rooms:', error);
    }
}

function initializeCalendar() {
    const calendarEl = document.getElementById('calendar');

    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: async (fetchInfo, successCallback, failureCallback) => {
            try {
                const response = await apiRequest('/bookings');
                const bookings = await response.json();

                const events = bookings.map(booking => ({
                    title: booking.title,
                    start: booking.start_time,
                    end: booking.end_time,
                    backgroundColor: booking.user_id === currentUser.id ? '#10B981' : '#3B82F6',
                    borderColor: booking.user_id === currentUser.id ? '#10B981' : '#3B82F6',
                    textColor: '#ffffff',
                    extendedProps: {
                        room: booking.room_name,
                        user: booking.user_name,
                        description: booking.description
                    }
                }));

                successCallback(events);
            } catch (error) {
                console.error('Error loading calendar events:', error);
                failureCallback(error);
            }
        },
        eventClick: function(info) {
            alert(`Meeting: ${info.event.title}\nRoom: ${info.event.extendedProps.room}\nUser: ${info.event.extendedProps.user}\nDescription: ${info.event.extendedProps.description || 'N/A'}`);
        },
        height: 'auto'
    });

    calendar.render();
}

// Modal functions
function openLoginModal() {
    document.getElementById('login-modal').classList.remove('hidden');
}

function closeLoginModal() {
    document.getElementById('login-modal').classList.add('hidden');
}

function openBookingModal() {
    loadRoomsForBooking();
    document.getElementById('booking-modal').classList.remove('hidden');
}

function closeBookingModal() {
    document.getElementById('booking-modal').classList.add('hidden');
    document.getElementById('booking-form').reset();
}

async function loadRoomsForBooking() {
    try {
        const response = await apiRequest('/rooms');
        const rooms = await response.json();

        const select = document.getElementById('booking-room');
        select.innerHTML = '<option value="">Select a room</option>' +
            rooms.map(room => `<option value="${room.id}">${room.name} (${room.capacity} people)</option>`).join('');

    } catch (error) {
        console.error('Error loading rooms for booking:', error);
    }
}

// Form handlers
document.addEventListener('submit', async (e) => {
    e.preventDefault();

    if (e.target.id === 'login-form') {
        const email = document.getElementById('login-email').value;
        const password = document.getElementById('login-password').value;
        await login(email, password);
    } else if (e.target.id === 'booking-form') {
        const formData = {
            room_id: parseInt(document.getElementById('booking-room').value),
            title: document.getElementById('booking-title').value,
            start_time: document.getElementById('booking-start').value,
            end_time: document.getElementById('booking-end').value,
            description: document.getElementById('booking-description').value,
            participants: document.getElementById('booking-participants').value
        };

        try {
            const response = await apiRequest('/bookings', {
                method: 'POST',
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (response.ok) {
                alert('Booking created successfully!');
                closeBookingModal();
                if (calendar) calendar.refetchEvents();
                loadDashboardData();
            } else {
                alert(result.error || 'Booking failed');
            }
        } catch (error) {
            console.error('Booking error:', error);
            alert('Booking failed');
        }
    }
});

// Utility functions
function openAddRoomModal() {
    // TODO: Implement add room modal
    alert('Add room functionality coming soon!');
}

function editRoom(id) {
    // TODO: Implement edit room modal
    alert('Edit room functionality coming soon!');
}

async function deleteRoom(id) {
    if (confirm('Are you sure you want to delete this room?')) {
        try {
            const response = await apiRequest(`/rooms/${id}`, {
                method: 'DELETE'
            });

            if (response.ok) {
                alert('Room deleted successfully!');
                loadRoomsForAdmin();
            } else {
                const result = await response.json();
                alert(result.error || 'Delete failed');
            }
        } catch (error) {
            console.error('Delete room error:', error);
            alert('Delete failed');
        }
    }
}