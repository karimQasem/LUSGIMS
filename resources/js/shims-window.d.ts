import { AxiosInstance } from "axios";
import { Config, Router } from "ziggy-js";
import InputParams from "ziggy-js";
import Lodash from "lodash";
declare global {
    interface Window {
        _: typeof Lodash;
        axios: AxiosInstance;
    }

    // declare function route(): Router;
    // declare function route(
    //     name: string,
    //     params?: typeof InputParams,
    //     absolute?: boolean,
    //     customZiggy?: Config
    // ): string;
}
