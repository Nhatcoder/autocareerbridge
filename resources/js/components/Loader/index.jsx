import SyncLoader from "react-spinners/SyncLoader";

function Loader() {
    const override = {
        display: "block",
        paddingTop: "5px",
        margin: "0 auto",
        borderColor: "red",
    };

    return (
        <SyncLoader color="#23c0e9" loading={true} cssOverride={override} />
    );
}

export default Loader;
