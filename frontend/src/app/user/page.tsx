"use client";

import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";
import Cookies from "js-cookie";

interface Book {
    id: number;
    title: string;
    author: string;
    genre: string;
    publisher: string;
    is_available: boolean;
}

interface Reservation {
    id: number;
    user_id: number;
    book_id: number;
    status: string;
    reserved_at: string;
    expires_at: string;
    issued_at: string;
    returned_at: string;
}

export default function UserDashboard() {
    const router = useRouter();
    
    const [books, setBooks] = useState<Book[]>([]);
    const [reservations, setReservations] = useState<Reservation[]>([]);

    const [showBooks, setShowBooks] = useState(true);

    const [user, setUser] = useState<{ name: string; role: string; id: number }>({
        name: "",
        role: "",
        id: 0,
      });

    const [filterAuthor, setFilterAuthor] = useState("");
    const [filterGenre, setFilterGenre] = useState("");
    const [filterPublisher, setFilterPublisher] = useState("");

    const [authorized, setAuthorized] = useState(false);

    useEffect(() => {
        const checkUser = async () => {
            const token = Cookies.get("token");
            if (!token) return router.push("/");

            try {
                const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/me`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                });

                if (!res.ok) throw new Error("Unauthorized");

                const data = await res.json();
                const user = data.data;

                if (user.role !== "user") return router.push(`/${user.role}`);
                setUser(user);
                fetchBooks();
                fetchReservations(user.id);
            } catch {
                router.push("/");
            }
        };

        checkUser();
    }, [router]);

    const fetchBooks = async () => {
        const token = Cookies.get("token");
        const query = new URLSearchParams();
        if (filterAuthor) query.append("author", filterAuthor);
        if (filterGenre) query.append("genre", filterGenre);
        if (filterPublisher) query.append("publisher", filterPublisher);

        const res = await fetch(
            `${process.env.NEXT_PUBLIC_API_URL}/books?${query.toString()}`,
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
            }
        );

        if (res.ok) {
            const data = await res.json();
            setBooks(data.data);
        }
    };

    const fetchReservations = async (userId: number) => {
        const token = Cookies.get("token");

        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/user/${userId}/reservations`, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });
        if (res.ok) {
            const data = await res.json();
            setReservations(data);
        }
    };

    const handleReserve = async (id: number) => {
        const token = Cookies.get("token");

        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/reservation`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({ book_id: id }),
        });

        if (res.ok) {
            alert("Книга успешно забронирована");
            fetchBooks();
            fetchReservations(user.id);
        } else {
            alert("Не удалось забронировать книгу");
        }
    };

    const handleCancelReservation = async (reservationId: number, bookId: number) => {
        const token = Cookies.get("token");
        if (!token) return;

        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/reservation/${reservationId}/status`, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({ status: "cancelled" }),
        });

        if (res.ok) {
            alert("Бронь отменена");
            setBooks((prevBooks) =>
                prevBooks.map((b) => (b.id === bookId ? { ...b, is_available: true } : b))
            );
            setReservations((prev) =>
                prev.map((r) =>
                    r.id === reservationId ? { ...r, status: "cancelled" } : r
                )
            );
        } else {
            alert("Не удалось отменить бронь");
        }
    };

    const handleNotify = async (bookId: number) => {
        const token = Cookies.get("token");

        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/notifyRequest`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({ book_id: bookId }),
        });

        if (res.ok) {
            alert("Вы будете уведомлены, когда книга станет доступна.");
        } else {
            alert("Ошибка при подписке на уведомление.");
        }
      };

    const handleLogout = async () => {
        const token = Cookies.get("token");
        if (!token) return;

        await fetch(`${process.env.NEXT_PUBLIC_API_URL}/logout`, {
            method: "POST",
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });

        Cookies.remove("token");
        window.location.href = "/";
    };

    if (!user) {
        return (
            <div className="min-h-screen flex items-center justify-center bg-gray-100 px-4">
                <div className="p-6 bg-white shadow-md rounded text-center text-gray-800">
                    Проверка доступа...
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gray-100 text-gray-900 px-6 py-10">
            <div className="max-w-7xl mx-auto space-y-10">
                <div>
                    <h2 className="text-4xl font-bold mb-2">Панель пользователя</h2>
                    <p className="text-xl">Добро пожаловать, <strong>{user.name}</strong>!</p>
                </div>

                <button
                    className="ml-auto bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded font-semibold"
                    onClick={handleLogout}
                >
                    Выйти
                </button>

                <div className="flex items-center justify-between">
                    <h3 className="text-2xl font-semibold pl-2 pt-2">
                        {showBooks ? "Книги" : "Мои брони"}
                    </h3>
                    <div className="space-x-2">
                        <button
                            className="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md"
                            onClick={() => setShowBooks(true)}
                        >
                            Показать книги
                        </button>
                        <button
                            className="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md"
                            onClick={() => setShowBooks(false)}
                        >
                            Показать брони
                        </button>
                    </div>
                </div>

                {showBooks && (
                    <>
                        <div className="bg-white p-4 rounded-lg shadow-md flex flex-wrap gap-4">
                            <input
                                type="text"
                                placeholder="Автор"
                                value={filterAuthor}
                                onChange={(e) => setFilterAuthor(e.target.value)}
                                className="border p-2 rounded-md w-full sm:w-1/4"
                            />
                            <input
                                type="text"
                                placeholder="Жанр"
                                value={filterGenre}
                                onChange={(e) => setFilterGenre(e.target.value)}
                                className="border p-2 rounded-md w-full sm:w-1/4"
                            />
                            <input
                                type="text"
                                placeholder="Издатель"
                                value={filterPublisher}
                                onChange={(e) => setFilterPublisher(e.target.value)}
                                className="border p-2 rounded-md w-full sm:w-1/4"
                            />
                            <button
                                onClick={fetchBooks}
                                className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
                            >
                                Применить фильтры
                            </button>
                            <button
                                onClick={() => {
                                    setFilterAuthor("");
                                    setFilterGenre("");
                                    setFilterPublisher("");
                                    fetchBooks();
                                }}
                                className="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded"
                            >
                                Сбросить
                            </button>
                        </div>

                        <div className="overflow-x-auto rounded-xl shadow-lg">
                            <table className="min-w-full bg-white text-base">
                                <thead className="bg-gray-200 text-left">
                                    <tr>
                                        <th className="p-2">Название</th>
                                        <th className="p-2">Автор</th>
                                        <th className="p-2">Жанр</th>
                                        <th className="p-2">Издатель</th>
                                        <th className="p-2">Доступность</th>
                                        <th className="p-2">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {books.map((book) => (
                                        <tr key={book.id} className="border-t">
                                            <td className="p-2">{book.title}</td>
                                            <td className="p-2">{book.author}</td>
                                            <td className="p-2">{book.genre}</td>
                                            <td className="p-2">{book.publisher}</td>
                                            <td className="p-2">
                                                <span className={book.is_available ? "text-green-600" : "text-red-600"}>
                                                    {book.is_available ? "Доступна" : "Недоступна"}
                                                </span>
                                            </td>
                                            <td className="p-2">
                                                <div className="flex gap-2">
                                                    <button
                                                        className="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-1 px-3 rounded-md shadow transition"
                                                        onClick={() => router.push(`/user/comments?book=${book.id}`)}
                                                    >
                                                        Комментарии
                                                    </button>

                                                    {book.is_available && (
                                                        <><button
                                                            className="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded-md shadow transition"
                                                            onClick={() => handleReserve(book.id)}
                                                        >
                                                            Забронировать
                                                        </button></>
                                                    )}
                                                    {!book.is_available &&(<button
                                                        className="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-1 px-3 rounded-md shadow transition ml-2"
                                                        onClick={() => handleNotify(book.id)}
                                                    >
                                                        Уведомить при доступности
                                                    </button>)}
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </>
                )}

                {!showBooks && (
                    <div className="overflow-x-auto rounded-xl shadow-lg">
                        <table className="min-w-full bg-white text-base">
                            <thead className="bg-gray-200 text-left">
                                <tr>
                                    <th className="p-2">Book ID</th>
                                    <th className="p-2">Статус</th>
                                    <th className="p-2">Забронирована</th>
                                    <th className="p-2">Истекает</th>
                                    <th className="p-2">Выдана</th>
                                    <th className="p-2">Возвращена</th>
                                    <th className="p-2">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                {reservations.map((r) => (
                                    <tr key={r.id} className="border-t">
                                        <td className="p-2">{r.book_id}</td>
                                        <td className="p-2">{r.status}</td>
                                        <td className="p-2">{r.reserved_at}</td>
                                        <td className="p-2">{r.expires_at}</td>
                                        <td className="p-2">{r.issued_at || "-"}</td>
                                        <td className="p-2">{r.returned_at || "-"}</td>
                                        <td className="p-2">
                                            {r.status === "reserved" && (
                                                <button
                                                    className="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded-md shadow transition"
                                                    onClick={() => handleCancelReservation(r.id, r.book_id)}
                                                >
                                                    Отменить
                                                </button>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                )}
            </div>
        </div>
    );
}
