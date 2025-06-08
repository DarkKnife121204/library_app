"use client";

import { useEffect, useState } from "react";
import { useRouter, useSearchParams } from "next/navigation";
import Cookies from "js-cookie";
interface Comment {
    id: number;
    user_id: number;
    book_id: number;
    rating: number;
    content: string;
    created_at: string;
    user?: {
        name: string;
    };
  }

export default function CommentsPage() {
    const router = useRouter();
    
    const searchParams = useSearchParams();
    const bookId = searchParams.get("book");

    const [authorized, setAuthorized] = useState(false);

    const [comments, setComments] = useState<Comment[]>([]);

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
                setAuthorized(true);
                fetchComments();
            } catch {
                router.push("/");
            }
        };

        checkUser();
    }, [router]);

    const fetchComments = async () => {
        const token = Cookies.get("token");
        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/book/${bookId}/comments`,{
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
            }
        );

        if (res.ok) {
            const data = await res.json();
            setComments(data.data);
        }
    };
    if (!authorized) {
        return (
            <div className="min-h-screen flex items-center justify-center bg-gray-100 px-4">
                <div className="p-6 bg-white shadow-md rounded text-center text-gray-800">
                    Загрузка...
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gray-100 px-6 py-10 text-gray-900">
            <div className="max-w-4xl mx-auto space-y-6">
                <div className="flex justify-between items-center">
                    <h1 className="text-3xl font-bold">Комментарии к книге #{bookId}</h1>
                    <button
                        onClick={() => router.push(`/user`)}
                        className="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded font-semibold"
                    >
                        Назад
                    </button>
                </div>
                <button
                    className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold"
                    onClick={() => router.push(`/user/comments/create?book=${bookId}`)}
                >
                    Оставить комментарий
                </button>
                {comments.length === 0 ? (
                    <div className="p-6 bg-white rounded-lg shadow text-gray-600 text-center">
                        Комментариев пока нет.
                    </div>
                ) : (
                    <div className="overflow-x-auto rounded-xl shadow-lg">
                        <table className="min-w-full bg-white text-base">
                            <thead className="bg-gray-200 text-left">
                                <tr>
                                    <th className="p-2">Оценка</th>
                                    <th className="p-2">Комментарий</th>
                                    <th className="p-2">Пользователь</th>
                                    <th className="p-2">Дата</th>
                                </tr>
                            </thead>
                            <tbody>
                                {comments.map((comment) => (
                                    <tr key={comment.id} className="border-t">
                                        <td className="p-2">{comment.rating ?? "—"}</td>
                                        <td className="p-2">{comment.content ?? "—"}</td>
                                        <td className="p-2">{comment.user?.name}</td>
                                        <td className="p-2">{comment.created_at}</td>
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
