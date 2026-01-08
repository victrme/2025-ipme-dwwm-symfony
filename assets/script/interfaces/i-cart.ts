import {IGame} from "./i-game";

export interface ICart {
    gamesDTO: IGame[];
    totalPrice: number;
}
