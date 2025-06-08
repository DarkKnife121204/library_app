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
    user: {
        name: string;
    };
    book_id: number;
    book: {
        title: string;
    };
    status: string;
    reserved_at: string;
    expires_at: string;
    issued_at: string | null;
    returned_at: string | null;
  }

export default function LibrarianDashboard() {
    const router = useRouter();

    const [books, setBooks] = useState<Book[]>([]);
    const [reservations, setReservations] = useState<Reservation[]>([]);

    const [showBooks, setShowBooks] = useState(true);
    const [user, setUser] = useState<{ name: string; role: string } | null>(null);

    const [authorized, setAuthorized] = useState(false);

    useEffect(() => {
        const checkLibrarian = async () => {
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

                if (user.role !== "librarian") return router.push(`/${user.role}`);

                setUser(user);
                setAuthorized(true);
                fetchBooks();
                fetchReservations();
            } catch {
                router.push("/");
            }
        };
        checkLibrarian();
    }, [router]);

    const fetchBooks = async () => {
        const token = Cookies.get("token");
        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/books`, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });

        if (res.ok) {
            const data = await res.json();
            setBooks(data.data);
        }
    };

    const fetchReservations = async () => {
        const token = Cookies.get("token");
        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/reservations`, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });

        if (res.ok) {
            const data = await res.json();
            setReservations(data.data);
        }
    };
    
    const handleStatusChange = async (reservationId: number, newStatus: "issued" | "returned") => {
        const token = Cookies.get("token");

        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/reservation/${reservationId}/status`, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({ status: newStatus }),
        });

        if (res.ok) {
            alert("Статус брони обновлён");
            fetchReservations();
        } else {
            alert("Ошибка при обновлении статуса.");
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

    const handleDelete = async (id: number) => {
        const token = Cookies.get("token");
        if (!token) return;

        try {
            const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/book/${id}`, {
                method: "DELETE",
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
            });

            if (res.ok) {
                setBooks(books.filter((b) => b.id !== id));
            } else {
                alert("Не удалось удалить книгу.");
            }
        } catch (error) {
            alert("Произошла ошибка при удалении книги.");
        }
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
                    <h2 className="text-4xl font-bold mb-2">Панель библиотекаря</h2>
                    <p className="text-xl">Добро пожаловать, <strong>{user.name}</strong>!</p>
                </div>

                <button
                    className="ml-auto bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded font-semibold"
                    onClick={handleLogout}
                >
                    Выйти
                </button>
                
                <div className="flex items-center justify-between">
                    <h3 className="text-2xl font-semibold pl-2 pt-2">{showBooks ? "Книги" : "Брони"}</h3>
                    <div className="space-x-2">
                        <button
                            className="bg-green-600 hover:bg-green-700 text-white text-base font-medium py-3 px-6 rounded-lg transition"
                            onClick={() => router.push("/librarian/books/create")}
                        >
                             Создать книгу
                        </button>
                        <button
                            className="bg-blue-600 hover:bg-blue-700 text-white text-base font-medium py-3 px-6 rounded-lg transition"
                            onClick={() => setShowBooks(true)}
                        >
                            Показать книги
                        </button>
                        <button
                            className="bg-indigo-600 hover:bg-indigo-700 text-white text-base font-medium py-3 px-6 rounded-lg transition"
                            onClick={() => setShowBooks(false)}
                        >
                            Показать брони
                        </button>
                    </div>
                </div>

                {showBooks ? (
                    <div className="overflow-x-auto rounded-xl shadow-lg">
                        <table className="min-w-full bg-white text-base">
                            <thead className="bg-gray-200 text-left">
                                <tr>
                                    <th className="p-2">ID</th>
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
                                        <td className="p-2">{book.id}</td>
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
                                            <button
                                                className="bg-red-600 hover:bg-red-700 text-white font-semibold py-1.5 px-4 rounded-md shadow transition duration-150 ease-in-out"
                                                onClick={() => handleDelete(book.id)}
                                            >
                                                Удалить
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                ) : (
                    <div className="overflow-x-auto rounded-xl shadow-lg">
                        <table className="min-w-full bg-white text-base">
                            <thead className="bg-gray-200 text-left">
                                <tr>
                                    <th className="p-2">ID</th>
                                    <th className="p-2">User ID</th>
                                    <th className="p-2">User</th>
                                    <th className="p-2">Book ID</th>
                                    <th className="p-2">Book</th>
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
                                        <td className="p-2">{r.id}</td>
                                        <td>{r.user_id}</td>
                                        <td>{r.user.name}</td>
                                        <td>{r.book_id}</td>
                                        <td>{ r.book.title }</td>
                                        <td className="p-2">{r.status}</td>
                                        <td className="p-2">{r.reserved_at}</td>
                                        <td className="p-2">{r.expires_at}</td>
                                        <td className="p-2">{r.issued_at}</td>
                                        <td className="p-2">{r.returned_at}</td>
                                        <td className="p-2">
                                            <div className="flex gap-2">
                                                {r.status === "reserved" && (
                                                    <button
                                                        onClick={() => handleStatusChange(r.id, "issued")}
                                                        className="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 py-1 rounded shadow transition"
                                                    >
                                                        Выдать
                                                    </button>
                                                )}

                                                {r.status === "issued" && (
                                                    <button
                                                        onClick={() => handleStatusChange(r.id, "returned")}
                                                        className="bg-green-600 hover:bg-green-700 text-white font-semibold px-3 py-1 rounded shadow transition"
                                                    >
                                                        Принять обратно
                                                    </button>
                                                )}
                                            </div>
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
